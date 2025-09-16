<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'inventory';

    protected $fillable = [
        'name',
        'description',
        'category',
        'sku',
        'unit',
        'current_quantity',
        'minimum_quantity',
        'maximum_quantity',
        'unit_cost',
        'total_cost',
        'supplier',
        'location',
        'expiry_date',
        'status',
        'notes',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'expiry_date' => 'date',
        'unit_cost' => 'decimal:2',
        'total_cost' => 'decimal:2',
        'current_quantity' => 'integer',
        'minimum_quantity' => 'integer',
        'maximum_quantity' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Define inventory categories
    public const CATEGORIES = [
        'diagnostic' => 'Diagnostic Supplies',
        'laboratory' => 'Laboratory Supplies',
        'medical' => 'Medical Equipment',
        'consumables' => 'Consumables',
        'pharmaceuticals' => 'Pharmaceuticals',
        'cleaning' => 'Cleaning Supplies',
        'office' => 'Office Supplies',
        'safety' => 'Safety Equipment',
    ];

    // Define inventory status
    public const STATUS = [
        'active' => 'Active',
        'inactive' => 'Inactive',
        'discontinued' => 'Discontinued',
        'expired' => 'Expired',
    ];

    // Define units of measurement
    public const UNITS = [
        'pcs' => 'Pieces',
        'box' => 'Box',
        'pack' => 'Pack',
        'bottle' => 'Bottle',
        'vial' => 'Vial',
        'tube' => 'Tube',
        'roll' => 'Roll',
        'sheet' => 'Sheet',
        'liter' => 'Liter',
        'ml' => 'Milliliter',
        'kg' => 'Kilogram',
        'gram' => 'Gram',
        'set' => 'Set',
    ];

    /**
     * Relationships
     */
    
    // User who created the inventory item
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // User who last updated the inventory item
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Inventory transactions (usage, restocking, etc.)
    public function transactions()
    {
        return $this->hasMany(InventoryTransaction::class);
    }

    /**
     * Accessors & Mutators
     */
    
    // Get formatted category name
    public function getCategoryNameAttribute()
    {
        return self::CATEGORIES[$this->category] ?? ucfirst($this->category);
    }

    // Get formatted status name
    public function getStatusNameAttribute()
    {
        return self::STATUS[$this->status] ?? ucfirst($this->status);
    }

    // Get formatted unit name
    public function getUnitNameAttribute()
    {
        return self::UNITS[$this->unit] ?? ucfirst($this->unit);
    }

    // Check if item is low stock
    public function getIsLowStockAttribute()
    {
        return $this->current_quantity <= $this->minimum_quantity;
    }

    // Check if item is out of stock
    public function getIsOutOfStockAttribute()
    {
        return $this->current_quantity <= 0;
    }

    // Check if item is expired
    public function getIsExpiredAttribute()
    {
        return $this->expiry_date && $this->expiry_date->isPast();
    }

    // Check if item is expiring soon (within 30 days)
    public function getIsExpiringSoonAttribute()
    {
        return $this->expiry_date && $this->expiry_date->diffInDays(now()) <= 30 && !$this->is_expired;
    }

    // Get stock status
    public function getStockStatusAttribute()
    {
        if ($this->is_out_of_stock) {
            return 'out_of_stock';
        } elseif ($this->is_low_stock) {
            return 'low_stock';
        } else {
            return 'in_stock';
        }
    }

    // Get stock status color for UI
    public function getStockStatusColorAttribute()
    {
        switch ($this->stock_status) {
            case 'out_of_stock':
                return 'red';
            case 'low_stock':
                return 'yellow';
            case 'in_stock':
                return 'green';
            default:
                return 'gray';
        }
    }

    // Calculate total cost automatically
    public function setCurrentQuantityAttribute($value)
    {
        $this->attributes['current_quantity'] = $value;
        $this->calculateTotalCost();
    }

    public function setUnitCostAttribute($value)
    {
        $this->attributes['unit_cost'] = $value;
        $this->calculateTotalCost();
    }

    /**
     * Scopes
     */
    
    // Scope for active items
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Scope for low stock items
    public function scopeLowStock($query)
    {
        return $query->whereRaw('current_quantity <= minimum_quantity');
    }

    // Scope for out of stock items
    public function scopeOutOfStock($query)
    {
        return $query->where('current_quantity', '<=', 0);
    }

    // Scope for expired items
    public function scopeExpired($query)
    {
        return $query->where('expiry_date', '<', now());
    }

    // Scope for expiring soon items
    public function scopeExpiringSoon($query)
    {
        return $query->whereBetween('expiry_date', [now(), now()->addDays(30)]);
    }

    // Scope by category
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    // Scope for search
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%")
              ->orWhere('sku', 'like', "%{$search}%")
              ->orWhere('supplier', 'like', "%{$search}%");
        });
    }

    /**
     * Methods
     */
    
    // Calculate total cost
    private function calculateTotalCost()
    {
        if (isset($this->attributes['current_quantity']) && isset($this->attributes['unit_cost'])) {
            $this->attributes['total_cost'] = $this->attributes['current_quantity'] * $this->attributes['unit_cost'];
        }
    }

    // Add stock
    public function addStock($quantity, $notes = null, $user_id = null)
    {
        $this->current_quantity += $quantity;
        $this->save();

        // Create transaction record
        $this->transactions()->create([
            'type' => 'restock',
            'quantity' => $quantity,
            'notes' => $notes,
            'user_id' => $user_id ?? auth()->id(),
        ]);

        return $this;
    }

    // Remove stock (usage)
    public function removeStock($quantity, $notes = null, $user_id = null)
    {
        if ($this->current_quantity >= $quantity) {
            $this->current_quantity -= $quantity;
            $this->save();

            // Create transaction record
            $this->transactions()->create([
                'type' => 'usage',
                'quantity' => -$quantity,
                'notes' => $notes,
                'user_id' => $user_id ?? auth()->id(),
            ]);

            return $this;
        }

        throw new \Exception('Insufficient stock. Available: ' . $this->current_quantity);
    }

    // Generate SKU if not provided
    public static function generateSku($category, $name)
    {
        $categoryCode = strtoupper(substr($category, 0, 3));
        $nameCode = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $name), 0, 3));
        $timestamp = now()->format('ymd');
        $random = str_pad(mt_rand(1, 999), 3, '0', STR_PAD_LEFT);
        
        return "{$categoryCode}-{$nameCode}-{$timestamp}-{$random}";
    }

    // Boot method to handle model events
    protected static function boot()
    {
        parent::boot();

        // Auto-generate SKU if not provided
        static::creating(function ($inventory) {
            if (empty($inventory->sku)) {
                $inventory->sku = self::generateSku($inventory->category, $inventory->name);
            }
            
            // Set created_by
            if (auth()->check()) {
                $inventory->created_by = auth()->id();
            }
        });

        // Set updated_by on update
        static::updating(function ($inventory) {
            if (auth()->check()) {
                $inventory->updated_by = auth()->id();
            }
        });
    }
}
