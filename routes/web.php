<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('categories', App\Http\Controllers\CategoryController::class);
    Route::resource('products', App\Http\Controllers\ProductController::class);
    Route::resource('stock.movements', App\Http\Controllers\StockMovementController::class)
        ->only(['create', 'store']);

    Route::resource('promotions', App\Http\Controllers\PromotionController::class);

    Route::resource('memberships', App\Http\Controllers\MembershipController::class);

    Route::post('promotion-assignments', [App\Http\Controllers\PromotionAssignmentController::class, 'store'])
        ->name('promotions.assignments.store');

    Route::get('promotion-assignments/{promotion}/create', [App\Http\Controllers\PromotionAssignmentController::class, 'create'])
        ->name('promotions.assignments.create');
});
