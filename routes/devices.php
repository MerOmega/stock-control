<?php

use App\Http\Controllers\DeviceController;

Route::prefix('devices')->group(
    function() {
        Route::get('/select-type', [DeviceController::class, 'selectType'])->name('devices.selectType');
        Route::get('/create/{type}', [DeviceController::class, 'create'])->name('devices.create.type');
        Route::get('/{device}/supplies/{supply}', [DeviceController::class, 'getSupplyDevice'])->name('devices.supply_device');
        Route::get('/{device}/record', [DeviceController::class, 'getDeviceRecord'])->name('devices.records');
        route::post('/store-supplies', [DeviceController::class, 'storeSupplies'])->name('devices.store_supplies');
        Route::delete('/{device}/supplies/{supply}', [DeviceController::class, 'removeSupply'])->name('devices.remove_supply');
        Route::put('/{device}/supplies/{supply}', [DeviceController::class, 'updateSupply'])->name('devices.update_supply');
    }
);

Route::resource('devices', DeviceController::class);
