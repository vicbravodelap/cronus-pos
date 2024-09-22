<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promotion extends Model
{
    use HasFactory, SoftDeletes;

    public static array $availableModels = [
        Membership::class => 'Membresía',
        Product::class => 'Producto'
    ];

    protected $casts = [
        'applicable_models' => 'array',
        'start_at' => 'datetime',
        'end_at' => 'datetime'
    ];

    protected $fillable = [
        'name',
        'description',
        'code',
        'type',
        'value',
        'start_at',
        'end_at',
        'applicable_models'
    ];

    public function memberships(): BelongsToMany
    {
        return $this->morphedByMany(Membership::class, 'promotionable')
            ->withTimestamps();
    }

    public function products(): BelongsToMany
    {
        return $this->morphedByMany(Product::class, 'promotionable')
            ->withTimestamps();
    }

    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        if ($search) {
            return $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%')
                ->orWhere('code', 'like', '%' . $search . '%');
        }

        return $query;
    }
}
