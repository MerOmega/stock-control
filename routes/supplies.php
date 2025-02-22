<?php

use App\Http\Controllers\SupplyController;
use Illuminate\Support\Facades\Route;

Route::prefix('supplies')->group(
    function() {
        Route::get('search', [SupplyController::class, 'search'])->name('supplies.search');
        Route::get('supply/{id}', [SupplyController::class, 'getSupply'])->name('supplies.supply');
        route::get('{supply}/record', [SupplyController::class, 'getSupplyRecord'])->name('supplies.records');
    }
);

Route::resource('supplies', SupplyController::class);
