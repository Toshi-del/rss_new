<?php

namespace App\View\Composers;

use Illuminate\View\View;
use App\Models\Inventory;

class AdminComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        // Get critical stock items (items at or below minimum stock)
        $criticalStockCount = Inventory::where('item_status', 'active')
            ->whereColumn('item_quantity', '<=', 'minimum_stock')
            ->count();
        
        // Get critical stock items details for notifications
        $criticalStockItems = Inventory::where('item_status', 'active')
            ->whereColumn('item_quantity', '<=', 'minimum_stock')
            ->orderBy('item_quantity', 'asc')
            ->limit(5)
            ->get(['id', 'item_name', 'item_quantity', 'minimum_stock']);

        $view->with([
            'criticalStockCount' => $criticalStockCount,
            'criticalStockItems' => $criticalStockItems
        ]);
    }
}
