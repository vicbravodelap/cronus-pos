<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStockMovementRequest;
use App\Models\Stock;
use App\Models\StockMovement;

class StockMovementController
{
    public function create()
    {
        return view('stock-movements.create');
    }

    public function store(StoreStockMovementRequest $request, Stock $stock)
    {
         StockMovement::create($request->validated());

        toast('Se ha actualizado el stock correctamente', 'success');

        return redirect()->route('stock.movements.create', $stock);
    }
}
