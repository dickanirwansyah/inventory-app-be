<?php

use App\Http\Controllers\API\APIPriceController;
use App\Http\Controllers\API\APIPriceDetailController;
use App\Http\Controllers\API\APIProductController;
use Illuminate\Support\Facades\Route;

Route::prefix('product')->group(function () {
    Route::post('create', [APIProductController::class, 'store']);
    Route::put('edit',[APIProductController::class, 'update']);
    Route::get('list',[APIProductController::class, 'index']);
    Route::post('delete',[APIProductController::class, 'destroy']);
    Route::get('search', [APIProductController::class, 'searchProductPriceDetail']);
});

Route::prefix('price')->group(function () {
    Route::post('create',[APIPriceController::class, 'store']);
    Route::put('edit',[APIPriceController::class, 'update']);
    Route::post('detail', [APIPriceDetailController::class, 'store']);
});