<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ConfigurationController;
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
route::get('/supplies/{supply}/record', [SupplyController::class, 'getSupplyRecord'])->name('supplies.records');
Route::resource('supplies', SupplyController::class);

Route::resource('sectors', SectorController::class);

Route::get('/devices/select-type', [DeviceController::class, 'selectType'])->name('devices.selectType');
Route::get('/devices/create/{type}', [DeviceController::class, 'create'])->name('devices.create');
Route::get('/devices/{device}/supplies/{supply}', [DeviceController::class, 'getSupplyDevice'])->name('devices.supply_device');
Route::get('/devices/{device}/record', [DeviceController::class, 'getDeviceRecord'])->name('devices.records');
route::post('/devices/store-supplies', [DeviceController::class, 'storeSupplies'])->name('devices.store_supplies');
Route::delete('/devices/{device}/supplies/{supply}', [DeviceController::class, 'removeSupply'])->name('devices.remove_supply');
Route::put('/devices/{device}/supplies/{supply}', [DeviceController::class, 'updateSupply'])->name('devices.update_supply');
Route::resource('devices', DeviceController::class);

Route::get('/configurations/edit', [ConfigurationController::class, 'edit'])->name('configurations.edit');
Route::put('configurations', [ConfigurationController::class,'update'])->name('configurations.update');
