<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_id',
        'amount',
        'status',
        'reason',
        'requested_at',
        'approved_at'
    ];

    protected $casts = [
        'amount' => 'float',
        'requested_at' => 'datetime',
        'approved_at' => 'datetime',
    ];

    /**
     * Get the campaign that owns the withdrawal.
     */
    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    /**
     * Scope a query to only include pending withdrawals.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include approved withdrawals.
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope a query to only include rejected withdrawals.
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    /**
     * Check if withdrawal is pending.
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }

    /**
     * Check if withdrawal is approved.
     */
    public function isApproved()
    {
        return $this->status === 'approved';
    }

    /**
     * Check if withdrawal is rejected.
     */
    public function isRejected()
    {
        return $this->status === 'rejected';
    }
}
