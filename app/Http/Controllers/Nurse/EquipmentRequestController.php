<?php

namespace App\Http\Controllers\Nurse;

use App\Http\Controllers\Controller;
use App\Models\EquipmentRequest;
use App\Models\EquipmentRequestItem;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EquipmentRequestController extends Controller
{
    /**
     * Display a listing of equipment requests.
     */
    public function index()
    {
        $requests = EquipmentRequest::with(['requester', 'approver', 'items.inventory'])
            ->where('requested_by', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('nurse.equipment-requests.index', compact('requests'));
    }

    /**
     * Show the form for creating a new equipment request.
     */
    public function create()
    {
        $inventory = Inventory::active()
            ->where('current_quantity', '>', 0)
            ->orderBy('category')
            ->orderBy('name')
            ->get();

        return view('nurse.equipment-requests.create', compact('inventory'));
    }

    /**
     * Store a newly created equipment request.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'department' => 'required|string|in:nurse,doctor,lab,admin',
            'purpose' => 'required|string|max:255',
            'priority' => 'required|string|in:low,medium,high',
            'date_needed' => 'required|date|after_or_equal:today',
            'notes' => 'nullable|string|max:1000',
            'equipment_items' => 'required|array|min:1',
            'equipment_items.*' => 'required|exists:inventory,id',
            'quantities' => 'required|array',
            'quantities.*' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Please check your input and try again.');
        }

        try {
            DB::beginTransaction();

            // Create the equipment request
            $equipmentRequest = EquipmentRequest::create([
                'requested_by' => auth()->id(),
                'department' => $request->department,
                'purpose' => $request->purpose,
                'priority' => $request->priority,
                'date_needed' => $request->date_needed,
                'notes' => $request->notes,
                'status' => 'pending',
            ]);

            // Create request items
            foreach ($request->equipment_items as $inventoryId) {
                $quantity = $request->quantities[$inventoryId] ?? 1;
                
                // Validate quantity against available stock
                $inventory = Inventory::find($inventoryId);
                if (!$inventory || $quantity > $inventory->current_quantity) {
                    throw new \Exception("Insufficient stock for {$inventory->name}. Available: {$inventory->current_quantity}");
                }

                EquipmentRequestItem::create([
                    'equipment_request_id' => $equipmentRequest->id,
                    'inventory_id' => $inventoryId,
                    'quantity_requested' => $quantity,
                    'status' => 'pending',
                ]);
            }

            DB::commit();

            return redirect()->route('nurse.annual-physical.index')
                ->with('success', "Equipment request #{$equipmentRequest->request_number} has been submitted successfully.");

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to submit equipment request: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified equipment request.
     */
    public function show(EquipmentRequest $equipmentRequest)
    {
        // Ensure user can only view their own requests
        if ($equipmentRequest->requested_by !== auth()->id()) {
            abort(403, 'Unauthorized access to equipment request.');
        }

        $equipmentRequest->load(['requester', 'approver', 'fulfiller', 'items.inventory']);

        return view('nurse.equipment-requests.show', compact('equipmentRequest'));
    }

    /**
     * Show the form for editing the specified equipment request.
     */
    public function edit(EquipmentRequest $equipmentRequest)
    {
        // Ensure user can only edit their own pending requests
        if ($equipmentRequest->requested_by !== auth()->id() || $equipmentRequest->status !== 'pending') {
            abort(403, 'Cannot edit this equipment request.');
        }

        $inventory = Inventory::active()
            ->where('current_quantity', '>', 0)
            ->orderBy('category')
            ->orderBy('name')
            ->get();

        $equipmentRequest->load('items.inventory');

        return view('nurse.equipment-requests.edit', compact('equipmentRequest', 'inventory'));
    }

    /**
     * Update the specified equipment request.
     */
    public function update(Request $request, EquipmentRequest $equipmentRequest)
    {
        // Ensure user can only update their own pending requests
        if ($equipmentRequest->requested_by !== auth()->id() || $equipmentRequest->status !== 'pending') {
            abort(403, 'Cannot update this equipment request.');
        }

        $validator = Validator::make($request->all(), [
            'priority' => 'required|string|in:low,medium,high',
            'date_needed' => 'required|date|after_or_equal:today',
            'notes' => 'nullable|string|max:1000',
            'equipment_items' => 'required|array|min:1',
            'equipment_items.*' => 'required|exists:inventory,id',
            'quantities' => 'required|array',
            'quantities.*' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Please check your input and try again.');
        }

        try {
            DB::beginTransaction();

            // Update the equipment request
            $equipmentRequest->update([
                'priority' => $request->priority,
                'date_needed' => $request->date_needed,
                'notes' => $request->notes,
            ]);

            // Delete existing items and create new ones
            $equipmentRequest->items()->delete();

            foreach ($request->equipment_items as $inventoryId) {
                $quantity = $request->quantities[$inventoryId] ?? 1;
                
                // Validate quantity against available stock
                $inventory = Inventory::find($inventoryId);
                if (!$inventory || $quantity > $inventory->current_quantity) {
                    throw new \Exception("Insufficient stock for {$inventory->name}. Available: {$inventory->current_quantity}");
                }

                EquipmentRequestItem::create([
                    'equipment_request_id' => $equipmentRequest->id,
                    'inventory_id' => $inventoryId,
                    'quantity_requested' => $quantity,
                    'status' => 'pending',
                ]);
            }

            DB::commit();

            return redirect()->route('nurse.equipment-requests.show', $equipmentRequest)
                ->with('success', "Equipment request #{$equipmentRequest->request_number} has been updated successfully.");

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update equipment request: ' . $e->getMessage());
        }
    }

    /**
     * Cancel the specified equipment request.
     */
    public function cancel(EquipmentRequest $equipmentRequest)
    {
        // Ensure user can only cancel their own pending requests
        if ($equipmentRequest->requested_by !== auth()->id() || $equipmentRequest->status !== 'pending') {
            abort(403, 'Cannot cancel this equipment request.');
        }

        $equipmentRequest->cancel('Cancelled by requester');

        return redirect()->route('nurse.equipment-requests.index')
            ->with('success', "Equipment request #{$equipmentRequest->request_number} has been cancelled.");
    }

    /**
     * Get inventory data for AJAX requests.
     */
    public function getInventory(Request $request)
    {
        try {
            $inventory = Inventory::active()
                ->where('current_quantity', '>', 0)
                ->select([
                    'id', 'name', 'description', 'category', 'current_quantity', 
                    'minimum_quantity', 'unit', 'unit_cost'
                ])
                ->orderBy('category')
                ->orderBy('name')
                ->get();

            // Add computed attributes
            $inventory = $inventory->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'description' => $item->description,
                    'category' => $item->category,
                    'current_quantity' => $item->current_quantity,
                    'minimum_quantity' => $item->minimum_quantity,
                    'unit' => $item->unit,
                    'unit_name' => $item->unit_name,
                    'unit_cost' => $item->unit_cost,
                    'is_low_stock' => $item->is_low_stock,
                    'is_out_of_stock' => $item->is_out_of_stock,
                ];
            });

            return response()->json([
                'success' => true,
                'inventory' => $inventory,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load inventory: ' . $e->getMessage(),
            ], 500);
        }
    }
}
