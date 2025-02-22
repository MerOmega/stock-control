<?php


use App\Http\Controllers\ConfigurationController;

Route::prefix('configurations')->group(
    function () {
        Route::get('/edit', [ConfigurationController::class, 'edit'])->name('configurations.edit');
        Route::put('', [ConfigurationController::class,'update'])->name('configurations.update');
    }
);
