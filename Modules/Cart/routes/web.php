<?php

use Illuminate\Support\Facades\Route;
use Modules\Cart\Http\Controllers\CartController;

Route::middleware(['auth'])->group(function () {

    Route::post('carts/add/{id}', [CartController::class, 'addToCart'])->name('cart.addToCart');
    Route::resource('carts', CartController::class)->names('cart');
});
