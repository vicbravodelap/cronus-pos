<?php

namespace App\Models;

use App\Traits\HasPromotions;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Membership extends Model
{
    use HasPromotions, HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'start_at',
        'end_at',
        'status',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime'
    ];

    public function getDaysLeftAttribute(): int
    {
        $endAt = Carbon::parse($this->end_at);
        $now = Carbon::now();

        if ($endAt->greaterThan($now)) {
            return (int) $now->diffInDays($endAt);
        }

        return 0;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function promotions(): MorphToMany
    {
        return $this->morphToMany(Promotion::class, 'promotionable');
    }

    public function memberAssistances(): HasMany
    {
        return $this->hasMany(MemberAssistance::class);
    }
}
