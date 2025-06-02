<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'target_amount',
        'current_amount',
        'deadline',
        'image',
        'user_id',
        'category_id',
        'status'
    ];

    protected $casts = [
        'deadline' => 'date',
        'target_amount' => 'float',
        'current_amount' => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class)->withDefault([
            'name' => 'Uncategorized',
            'slug' => 'uncategorized'
        ]);
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class);
    }

    public function getProgressPercentageAttribute()
    {
        if ($this->target_amount == 0) return 0;
        return min(100, round(($this->current_amount / $this->target_amount) * 100));
    }

    public function getRemainingDaysAttribute()
    {
        return $this->deadline->diffInDays(now());
    }

    public function getTotalWithdrawnAttribute()
    {
        return $this->withdrawals()->approved()->sum('amount');
    }

    public function getAvailableForWithdrawalAttribute()
    {
        return $this->current_amount - $this->total_withdrawn;
    }

    public function canRequestWithdrawal()
    {
        return $this->available_for_withdrawal > 0 && $this->user_id === auth()->id();
    }
}
