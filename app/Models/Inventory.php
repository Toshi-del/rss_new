<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inventory extends Model
{
    use HasFactory;

    protected $table = 'inventory';

    protected $fillable = [
        'item_name',
        'item_quantity',
        'item_status',
        'description',
        'unit_price',
        'category',
        'supplier',
        'expiry_date',
        'minimum_stock'
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'expiry_date' => 'date',
        'item_quantity' => 'integer',
        'minimum_stock' => 'integer'
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('item_status', 'active');
    }

    public function scopeOutOfStock($query)
    {
        return $query->where('item_status', 'out_of_stock');
    }

    public function scopeLowStock($query)
    {
        return $query->whereColumn('item_quantity', '<=', 'minimum_stock');
    }

    // Accessors
    public function getIsLowStockAttribute()
    {
        return $this->item_quantity <= $this->minimum_stock;
    }

    public function getStatusBadgeAttribute()
    {
        return match($this->item_status) {
            'active' => 'bg-green-100 text-green-800',
            'inactive' => 'bg-gray-100 text-gray-800',
            'out_of_stock' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }
}
