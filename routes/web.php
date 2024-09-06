<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\SectorController;
use App\Http\Controllers\SupplyController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('categories', CategoryController::class);

Route::get('supplies/search', [SupplyController::class, 'search'])->name('supplies.search');
Route::get('supplies/supply/{id}', [SupplyController::class, 'getSupply'])->name('supplies.supply');
Route::resource('supplies', SupplyController::class);

Route::resource('sectors', SectorController::class);

Route::get('/devices/select-type', [DeviceController::class, 'selectType'])->name('devices.selectType');
Route::get('/devices/create/{type}', [DeviceController::class, 'create'])->name('devices.create');
route::post('/devices/store-supplies', [DeviceController::class, 'storeSupplies'])->name('devices.store_supplies');
Route::delete('/devices/{device}/supplies/{supply}', [DeviceController::class, 'removeSupply'])->name('devices.remove_supply');
Route::put('/devices/{device}/supplies/{supply}', [DeviceController::class, 'updateSupply'])->name('devices.update_supply');
Route::resource('devices', DeviceController::class);
