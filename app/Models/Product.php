<?php

namespace App\Models;

use App\Traits\HasPromotions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    use SoftDeletes, HasFactory, HasPromotions;

    protected $fillable = [
        'name',
        'description',
        'category_id',
        'price',
        'discount',
        'sku',
        'status',
        'image_path'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function stock(): HasOne
    {
        return $this->hasOne(Stock::class);
    }

    public function promotions(): MorphToMany
    {
        return $this->morphToMany(Promotion::class, 'promotionable');
    }

    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        if ($search) {
            return $query->where('name', 'LIKE', "%{$search}%")
                ->orWhere('sku', 'LIKE', "%{$search}%");
        }

        return $query;
    }

    public function saleOrderItems(): HasMany
    {
        return $this->hasMany(SaleOrderItem::class);
    }
}
