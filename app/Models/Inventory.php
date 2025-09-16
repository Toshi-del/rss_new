<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = [
        'item_name',
        'item_quantity',
        'status',
        'description',
    ];

    protected $casts = [
        'item_quantity' => 'integer',
    ];

    // Automatically update status based on quantity
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($inventory) {
            $inventory->status = $inventory->item_quantity > 0 ? 'in-stock' : 'out-of-stock';
        });
    }

    // Scope for in-stock items
    public function scopeInStock($query)
    {
        return $query->where('status', 'in-stock');
    }

    // Scope for out-of-stock items
    public function scopeOutOfStock($query)
    {
        return $query->where('status', 'out-of-stock');
    }
}
