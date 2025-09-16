<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class InventoryController extends Controller
{
    /**
     * Display the inventory management page
     */
    public function index(Request $request)
    {
        // Get filter parameters
        $category = $request->get('category');
        $status = $request->get('status');
        $search = $request->get('search');
        $stockFilter = $request->get('stock_filter'); // all, low_stock, out_of_stock

        // Build query
        $query = Inventory::with(['creator', 'updater']);

        // Apply filters
        if ($category) {
            $query->byCategory($category);
        }

        if ($status) {
            $query->where('status', $status);
        }

        if ($search) {
            $query->search($search);
        }

        // Apply stock filters
        switch ($stockFilter) {
            case 'low_stock':
                $query->lowStock();
                break;
            case 'out_of_stock':
                $query->outOfStock();
                break;
            case 'expired':
                $query->expired();
                break;
            case 'expiring_soon':
                $query->expiringSoon();
                break;
        }

        // Get paginated results
        $inventory = $query->orderBy('name')->paginate(15);

        // Get statistics for dashboard cards
        $stats = $this->getInventoryStatistics();

        return view('admin.inventory.index', compact('inventory', 'stats', 'category', 'status', 'search', 'stockFilter'));
    }

    /**
     * Show the form for creating a new inventory item
     */
    public function create()
    {
        return view('admin.inventory.create');
    }

    /**
     * Store a newly created inventory item
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'category' => ['required', Rule::in(array_keys(Inventory::CATEGORIES))],
            'sku' => 'nullable|string|max:100|unique:inventory,sku',
            'unit' => ['required', Rule::in(array_keys(Inventory::UNITS))],
            'current_quantity' => 'required|integer|min:0',
            'minimum_quantity' => 'required|integer|min:0',
            'maximum_quantity' => 'nullable|integer|min:0',
            'unit_cost' => 'required|numeric|min:0',
            'supplier' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'expiry_date' => 'nullable|date|after:today',
            'status' => ['required', Rule::in(array_keys(Inventory::STATUS))],
            'notes' => 'nullable|string|max:1000',
        ]);

        // Validate maximum quantity if provided
        if ($validated['maximum_quantity'] && $validated['maximum_quantity'] < $validated['minimum_quantity']) {
            return back()->withErrors(['maximum_quantity' => 'Maximum quantity must be greater than minimum quantity.'])->withInput();
        }

        try {
            DB::beginTransaction();

            // Create inventory item
            $inventory = Inventory::create($validated);

            DB::commit();

            return redirect()->route('admin.inventory.index')
                ->with('success', 'Inventory item created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to create inventory item: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Display the specified inventory item
     */
    public function show(Inventory $inventory)
    {
        $inventory->load(['creator', 'updater', 'transactions.user']);
        
        // Get recent transactions
        $recentTransactions = $inventory->transactions()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.inventory.show', compact('inventory', 'recentTransactions'));
    }

    /**
     * Show the form for editing the specified inventory item
     */
    public function edit(Inventory $inventory)
    {
        return view('admin.inventory.edit', compact('inventory'));
    }

    /**
     * Update the specified inventory item
     */
    public function update(Request $request, Inventory $inventory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'category' => ['required', Rule::in(array_keys(Inventory::CATEGORIES))],
            'sku' => ['nullable', 'string', 'max:100', Rule::unique('inventory', 'sku')->ignore($inventory->id)],
            'unit' => ['required', Rule::in(array_keys(Inventory::UNITS))],
            'current_quantity' => 'required|integer|min:0',
            'minimum_quantity' => 'required|integer|min:0',
            'maximum_quantity' => 'nullable|integer|min:0',
            'unit_cost' => 'required|numeric|min:0',
            'supplier' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'expiry_date' => 'nullable|date',
            'status' => ['required', Rule::in(array_keys(Inventory::STATUS))],
            'notes' => 'nullable|string|max:1000',
        ]);

        // Validate maximum quantity if provided
        if ($validated['maximum_quantity'] && $validated['maximum_quantity'] < $validated['minimum_quantity']) {
            return back()->withErrors(['maximum_quantity' => 'Maximum quantity must be greater than minimum quantity.'])->withInput();
        }

        try {
            DB::beginTransaction();

            $inventory->update($validated);

            DB::commit();

            return redirect()->route('admin.inventory.index')
                ->with('success', 'Inventory item updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to update inventory item: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Remove the specified inventory item
     */
    public function destroy(Inventory $inventory)
    {
        try {
            DB::beginTransaction();

            $inventory->delete();

            DB::commit();

            return redirect()->route('admin.inventory.index')
                ->with('success', 'Inventory item deleted successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to delete inventory item: ' . $e->getMessage()]);
        }
    }

    /**
     * Add stock to inventory item
     */
    public function addStock(Request $request, Inventory $inventory)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:500',
        ]);

        try {
            DB::beginTransaction();

            $inventory->addStock(
                $validated['quantity'],
                $validated['notes'] ?? 'Stock added via admin panel',
                Auth::id()
            );

            DB::commit();

            return back()->with('success', "Added {$validated['quantity']} {$inventory->unit_name} to {$inventory->name}.");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to add stock: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove stock from inventory item
     */
    public function removeStock(Request $request, Inventory $inventory)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $inventory->current_quantity,
            'notes' => 'nullable|string|max:500',
        ]);

        try {
            DB::beginTransaction();

            $inventory->removeStock(
                $validated['quantity'],
                $validated['notes'] ?? 'Stock removed via admin panel',
                Auth::id()
            );

            DB::commit();

            return back()->with('success', "Removed {$validated['quantity']} {$inventory->unit_name} from {$inventory->name}.");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to remove stock: ' . $e->getMessage()]);
        }
    }

    /**
     * Get inventory statistics for dashboard
     */
    private function getInventoryStatistics()
    {
        return [
            'total_items' => Inventory::active()->count(),
            'low_stock_items' => Inventory::active()->lowStock()->count(),
            'out_of_stock_items' => Inventory::active()->outOfStock()->count(),
            'expired_items' => Inventory::active()->expired()->count(),
            'expiring_soon_items' => Inventory::active()->expiringSoon()->count(),
            'total_value' => Inventory::active()->sum('total_cost'),
            'categories_count' => Inventory::active()->distinct('category')->count(),
            'recent_activity' => $this->getRecentInventoryActivity(),
        ];
    }

    /**
     * Get recent inventory activity
     */
    private function getRecentInventoryActivity()
    {
        return Inventory::with(['creator', 'updater'])
            ->where('updated_at', '>=', Carbon::now()->subDays(7))
            ->orderBy('updated_at', 'desc')
            ->limit(5)
            ->get();
    }

    /**
     * Export inventory data
     */
    public function export(Request $request)
    {
        $format = $request->get('format', 'csv');
        
        // Get filtered data
        $query = Inventory::with(['creator', 'updater']);
        
        // Apply same filters as index
        if ($request->get('category')) {
            $query->byCategory($request->get('category'));
        }
        
        if ($request->get('status')) {
            $query->where('status', $request->get('status'));
        }
        
        if ($request->get('search')) {
            $query->search($request->get('search'));
        }

        $inventory = $query->orderBy('name')->get();

        if ($format === 'csv') {
            return $this->exportToCsv($inventory);
        }

        return back()->withErrors(['error' => 'Invalid export format.']);
    }

    /**
     * Export inventory to CSV
     */
    private function exportToCsv($inventory)
    {
        $filename = 'inventory_export_' . Carbon::now()->format('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($inventory) {
            $file = fopen('php://output', 'w');
            
            // CSV headers
            fputcsv($file, [
                'SKU', 'Name', 'Description', 'Category', 'Unit', 
                'Current Quantity', 'Minimum Quantity', 'Maximum Quantity',
                'Unit Cost', 'Total Cost', 'Supplier', 'Location',
                'Expiry Date', 'Status', 'Stock Status', 'Notes',
                'Created At', 'Updated At'
            ]);

            // CSV data
            foreach ($inventory as $item) {
                fputcsv($file, [
                    $item->sku,
                    $item->name,
                    $item->description,
                    $item->category_name,
                    $item->unit_name,
                    $item->current_quantity,
                    $item->minimum_quantity,
                    $item->maximum_quantity,
                    $item->unit_cost,
                    $item->total_cost,
                    $item->supplier,
                    $item->location,
                    $item->expiry_date ? $item->expiry_date->format('Y-m-d') : '',
                    $item->status_name,
                    ucfirst(str_replace('_', ' ', $item->stock_status)),
                    $item->notes,
                    $item->created_at->format('Y-m-d H:i:s'),
                    $item->updated_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Get low stock alerts
     */
    public function lowStockAlerts()
    {
        $lowStockItems = Inventory::active()
            ->lowStock()
            ->with(['creator', 'updater'])
            ->orderBy('current_quantity', 'asc')
            ->get();

        $outOfStockItems = Inventory::active()
            ->outOfStock()
            ->with(['creator', 'updater'])
            ->orderBy('name')
            ->get();

        return view('admin.inventory.alerts', compact('lowStockItems', 'outOfStockItems'));
    }

    /**
     * Get expiry alerts
     */
    public function expiryAlerts()
    {
        $expiredItems = Inventory::active()
            ->expired()
            ->with(['creator', 'updater'])
            ->orderBy('expiry_date', 'asc')
            ->get();

        $expiringSoonItems = Inventory::active()
            ->expiringSoon()
            ->with(['creator', 'updater'])
            ->orderBy('expiry_date', 'asc')
            ->get();

        return view('admin.inventory.expiry', compact('expiredItems', 'expiringSoonItems'));
    }
}
