<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'inventory_id',
        'type',
        'quantity',
        'quantity_before',
        'quantity_after',
        'unit_cost_at_time',
        'total_cost',
        'reference_type',
        'reference_id',
        'batch_number',
        'user_id',
        'notes',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'quantity_before' => 'integer',
        'quantity_after' => 'integer',
        'unit_cost_at_time' => 'decimal:2',
        'total_cost' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Transaction types
    public const TYPES = [
        'restock' => 'Restock',
        'usage' => 'Usage',
        'adjustment' => 'Adjustment',
        'expired' => 'Expired',
        'damaged' => 'Damaged',
        'transfer' => 'Transfer',
    ];

    /**
     * Relationships
     */
    
    // Inventory item this transaction belongs to
    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    // User who performed the transaction
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Accessors
     */
    
    // Get formatted type name
    public function getTypeNameAttribute()
    {
        return self::TYPES[$this->type] ?? ucfirst($this->type);
    }

    // Check if transaction increases stock
    public function getIsIncreaseAttribute()
    {
        return $this->quantity > 0;
    }

    // Check if transaction decreases stock
    public function getIsDecreaseAttribute()
    {
        return $this->quantity < 0;
    }

    // Get absolute quantity for display
    public function getAbsoluteQuantityAttribute()
    {
        return abs($this->quantity);
    }

    /**
     * Scopes
     */
    
    // Scope by transaction type
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    // Scope for increases (restocks)
    public function scopeIncreases($query)
    {
        return $query->where('quantity', '>', 0);
    }

    // Scope for decreases (usage)
    public function scopeDecreases($query)
    {
        return $query->where('quantity', '<', 0);
    }

    // Scope for recent transactions
    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    // Scope by user
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Boot method to handle model events
     */
    protected static function boot()
    {
        parent::boot();

        // Automatically set quantity_before and quantity_after
        static::creating(function ($transaction) {
            $inventory = Inventory::find($transaction->inventory_id);
            if ($inventory) {
                $transaction->quantity_before = $inventory->current_quantity;
                $transaction->quantity_after = $inventory->current_quantity + $transaction->quantity;
                
                // Set cost information if not provided
                if (!$transaction->unit_cost_at_time) {
                    $transaction->unit_cost_at_time = $inventory->unit_cost;
                }
                
                if (!$transaction->total_cost) {
                    $transaction->total_cost = abs($transaction->quantity) * $transaction->unit_cost_at_time;
                }
            }
        });
    }
}
