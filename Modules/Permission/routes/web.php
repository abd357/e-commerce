<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Modules\Permission\Http\Controllers\PermissionController;

Route::middleware(['auth'])->group(function () {
    Route::resource('permissions', PermissionController::class)->names('permission');
});
