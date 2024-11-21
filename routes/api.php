<?php

use App\Http\Controllers\API\APIProductController;
use Illuminate\Support\Facades\Route;

Route::prefix('product')->group(function () {
    Route::post('create', [APIProductController::class, 'store']);
    Route::put('edit',[APIProductController::class, 'update']);
    Route::get('list',[APIProductController::class, 'index']);
});