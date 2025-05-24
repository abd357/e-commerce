<?php

use Illuminate\Support\Facades\Route;
use Modules\Product\Http\Controllers\ProductController;
use Spatie\Permission\Middleware\RoleMiddleware;

Route::middleware('auth')->group(function () {
    Route::resource('product', ProductController::class)->names('product');
});
