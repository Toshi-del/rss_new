<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EquipmentRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'request_number',
        'requested_by',
        'department',
        'purpose',
        'priority',
        'date_needed',
        'notes',
        'status',
        'approved_by',
        'approved_at',
        'rejected_reason',
        'fulfilled_by',
        'fulfilled_at',
    ];

    protected $casts = [
        'date_needed' => 'date',
        'approved_at' => 'datetime',
        'fulfilled_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Define priority levels
    public const PRIORITIES = [
        'low' => 'Low - Can wait',
        'medium' => 'Medium - Needed soon',
        'high' => 'High - Urgent',
    ];

    // Define status options
    public const STATUSES = [
        'pending' => 'Pending Review',
        'approved' => 'Approved',
        'rejected' => 'Rejected',
        'fulfilled' => 'Fulfilled',
        'cancelled' => 'Cancelled',
    ];

    // Define departments
    public const DEPARTMENTS = [
        'nurse' => 'Nursing Department',
        'doctor' => 'Medical Department',
        'lab' => 'Laboratory',
        'admin' => 'Administration',
    ];

    /**
     * Relationships
     */
    
    // User who made the request
    public function requester()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    // User who approved the request
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // User who fulfilled the request
    public function fulfiller()
    {
        return $this->belongsTo(User::class, 'fulfilled_by');
    }

    // Equipment request items
    public function items()
    {
        return $this->hasMany(EquipmentRequestItem::class);
    }

    /**
     * Accessors & Mutators
     */
    
    // Get formatted priority name
    public function getPriorityNameAttribute()
    {
        return self::PRIORITIES[$this->priority] ?? ucfirst($this->priority);
    }

    // Get formatted status name
    public function getStatusNameAttribute()
    {
        return self::STATUSES[$this->status] ?? ucfirst($this->status);
    }

    // Get formatted department name
    public function getDepartmentNameAttribute()
    {
        return self::DEPARTMENTS[$this->department] ?? ucfirst($this->department);
    }

    // Get status color for UI
    public function getStatusColorAttribute()
    {
        switch ($this->status) {
            case 'pending':
                return 'yellow';
            case 'approved':
                return 'blue';
            case 'rejected':
                return 'red';
            case 'fulfilled':
                return 'green';
            case 'cancelled':
                return 'gray';
            default:
                return 'gray';
        }
    }

    // Get priority color for UI
    public function getPriorityColorAttribute()
    {
        switch ($this->priority) {
            case 'high':
                return 'red';
            case 'medium':
                return 'yellow';
            case 'low':
                return 'green';
            default:
                return 'gray';
        }
    }

    /**
     * Scopes
     */
    
    // Scope by status
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Scope by department
    public function scopeByDepartment($query, $department)
    {
        return $query->where('department', $department);
    }

    // Scope by priority
    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    // Scope for pending requests
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // Scope for approved requests
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    // Scope for fulfilled requests
    public function scopeFulfilled($query)
    {
        return $query->where('status', 'fulfilled');
    }

    /**
     * Methods
     */
    
    // Generate request number
    public static function generateRequestNumber()
    {
        $prefix = 'EQR';
        $date = now()->format('Ymd');
        $sequence = str_pad(self::whereDate('created_at', now())->count() + 1, 4, '0', STR_PAD_LEFT);
        
        return "{$prefix}-{$date}-{$sequence}";
    }

    // Approve request
    public function approve($approver_id, $notes = null)
    {
        $this->update([
            'status' => 'approved',
            'approved_by' => $approver_id,
            'approved_at' => now(),
            'notes' => $notes ? $this->notes . "\n\nApproval Notes: " . $notes : $this->notes,
        ]);

        return $this;
    }

    // Reject request
    public function reject($approver_id, $reason)
    {
        $this->update([
            'status' => 'rejected',
            'approved_by' => $approver_id,
            'approved_at' => now(),
            'rejected_reason' => $reason,
        ]);

        return $this;
    }

    // Fulfill request
    public function fulfill($fulfiller_id, $notes = null)
    {
        $this->update([
            'status' => 'fulfilled',
            'fulfilled_by' => $fulfiller_id,
            'fulfilled_at' => now(),
            'notes' => $notes ? $this->notes . "\n\nFulfillment Notes: " . $notes : $this->notes,
        ]);

        return $this;
    }

    // Cancel request
    public function cancel($reason = null)
    {
        $this->update([
            'status' => 'cancelled',
            'rejected_reason' => $reason,
        ]);

        return $this;
    }

    // Boot method to handle model events
    protected static function boot()
    {
        parent::boot();

        // Auto-generate request number
        static::creating(function ($request) {
            if (empty($request->request_number)) {
                $request->request_number = self::generateRequestNumber();
            }
        });
    }
}
