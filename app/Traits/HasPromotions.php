<?php

namespace App\Traits;

use App\Models\Promotion;

/**
 * @method morphMany(string $class, string $string)
 */
trait HasPromotions
{
    public function promotions(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Promotion::class, 'promotable');
    }
}
