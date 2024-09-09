<?php

namespace App\Observers;

use App\Models\StockMovement;

class StockObserver
{
    /**
     * Handle the StockMovement "created" event.
     */
    public function created(StockMovement $stockMovement): void
    {
        $stock = $stockMovement->stock;

        $stock->quantity += ($stockMovement->type === 'in' ? 1 : -1) * $stockMovement->quantity;
        $stock->save();
    }
//
//    /**
//     * Handle the StockMovement "updated" event.
//     */
//    public function updated(StockMovement $stockMovement): void
//    {
//        //
//    }
//
//    /**
//     * Handle the StockMovement "deleted" event.
//     */
//    public function deleted(StockMovement $stockMovement): void
//    {
//        //
//    }
//
//    /**
//     * Handle the StockMovement "restored" event.
//     */
//    public function restored(StockMovement $stockMovement): void
//    {
//        //
//    }
//
//    /**
//     * Handle the StockMovement "force deleted" event.
//     */
//    public function forceDeleted(StockMovement $stockMovement): void
//    {
//        //
//    }
}
