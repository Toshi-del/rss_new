<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class AccountInvitationLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'token',
        'email',
        'role',
        'company_id',
        'expires_at',
        'is_used',
        'created_by'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_used' => 'boolean',
    ];

    /**
     * Get the company that created this invitation
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(User::class, 'company_id');
    }

    /**
     * Get the user who created this invitation
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Check if the invitation link has expired
     */
    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    /**
     * Check if the invitation link is valid (not expired and not used)
     */
    public function isValid(): bool
    {
        return !$this->is_used && !$this->isExpired();
    }

    /**
     * Mark the invitation as used
     */
    public function markAsUsed(): void
    {
        $this->update(['is_used' => true]);
    }

    /**
     * Generate a unique token for the invitation
     */
    public static function generateToken(): string
    {
        do {
            $token = \Str::random(64);
        } while (static::where('token', $token)->exists());

        return $token;
    }

    /**
     * Create a new invitation link
     */
    public static function createInvitation(array $data): self
    {
        return static::create([
            'token' => static::generateToken(),
            'email' => $data['email'],
            'role' => $data['role'],
            'company_id' => $data['company_id'],
            'expires_at' => $data['expires_at'],
            'created_by' => $data['created_by'],
        ]);
    }
}
