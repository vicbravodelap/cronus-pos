<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class StockMovement extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'stock_id',
        'quantity',
        'date',
        'type',
        'reason',
    ];

    public function stock(): BelongsTo
    {
        return $this->belongsTo(Stock::class);
    }

    public function getCreatedAtAttribute($value): string
    {
        return Carbon::parse($value)->format('d-m-Y H:i:s');
    }
}
