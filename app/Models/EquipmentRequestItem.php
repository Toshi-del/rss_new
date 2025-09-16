<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentRequestItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipment_request_id',
        'inventory_id',
        'quantity_requested',
        'quantity_approved',
        'quantity_fulfilled',
        'notes',
        'status',
    ];

    protected $casts = [
        'quantity_requested' => 'integer',
        'quantity_approved' => 'integer',
        'quantity_fulfilled' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Define status options
    public const STATUSES = [
        'pending' => 'Pending',
        'approved' => 'Approved',
        'partial' => 'Partially Fulfilled',
        'fulfilled' => 'Fulfilled',
        'rejected' => 'Rejected',
    ];

    /**
     * Relationships
     */
    
    // Equipment request this item belongs to
    public function equipmentRequest()
    {
        return $this->belongsTo(EquipmentRequest::class);
    }

    // Inventory item being requested
    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    /**
     * Accessors & Mutators
     */
    
    // Get formatted status name
    public function getStatusNameAttribute()
    {
        return self::STATUSES[$this->status] ?? ucfirst($this->status);
    }

    // Get status color for UI
    public function getStatusColorAttribute()
    {
        switch ($this->status) {
            case 'pending':
                return 'yellow';
            case 'approved':
                return 'blue';
            case 'partial':
                return 'orange';
            case 'fulfilled':
                return 'green';
            case 'rejected':
                return 'red';
            default:
                return 'gray';
        }
    }

    // Check if item is fully fulfilled
    public function getIsFullyFulfilledAttribute()
    {
        return $this->quantity_fulfilled >= $this->quantity_requested;
    }

    // Check if item is partially fulfilled
    public function getIsPartiallyFulfilledAttribute()
    {
        return $this->quantity_fulfilled > 0 && $this->quantity_fulfilled < $this->quantity_requested;
    }

    // Get remaining quantity to fulfill
    public function getRemainingQuantityAttribute()
    {
        return max(0, $this->quantity_requested - $this->quantity_fulfilled);
    }

    /**
     * Scopes
     */
    
    // Scope by status
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Scope for pending items
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // Scope for approved items
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    // Scope for fulfilled items
    public function scopeFulfilled($query)
    {
        return $query->where('status', 'fulfilled');
    }

    /**
     * Methods
     */
    
    // Approve item with specific quantity
    public function approve($quantity = null)
    {
        $this->update([
            'status' => 'approved',
            'quantity_approved' => $quantity ?? $this->quantity_requested,
        ]);

        return $this;
    }

    // Reject item
    public function reject($reason = null)
    {
        $this->update([
            'status' => 'rejected',
            'notes' => $reason ? $this->notes . "\n\nRejection Reason: " . $reason : $this->notes,
        ]);

        return $this;
    }

    // Fulfill item with specific quantity
    public function fulfill($quantity)
    {
        $newFulfilledQuantity = $this->quantity_fulfilled + $quantity;
        
        // Determine status based on fulfillment
        $status = 'fulfilled';
        if ($newFulfilledQuantity < $this->quantity_requested) {
            $status = 'partial';
        }

        $this->update([
            'status' => $status,
            'quantity_fulfilled' => $newFulfilledQuantity,
        ]);

        // Update inventory stock
        if ($this->inventory) {
            $this->inventory->removeStock($quantity, "Equipment request fulfillment: {$this->equipmentRequest->request_number}");
        }

        return $this;
    }
}
