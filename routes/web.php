<?php

use App\Http\Controllers\StripeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('product::index');
// });

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::middleware(['auth'])->group(function () {
    Route::get('/',[StripeController::class, 'index'])->name('index');
    Route::get('/success',[StripeController::class, 'success'])->name('success');
    Route::post('/checkout',[StripeController::class, 'checkout'])->name('checkout');
    
});