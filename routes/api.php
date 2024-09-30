<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('promotions/search', \App\Http\Controllers\PromotionSearchController::class)->name('promotions.search');
