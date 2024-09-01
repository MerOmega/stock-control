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
Route::resource('supplies', SupplyController::class);
Route::resource('sectors', SectorController::class);

Route::get('/devices/select-type', [DeviceController::class, 'selectType'])->name('devices.selectType');
Route::get('/devices/create/{type}', [DeviceController::class, 'create'])->name('devices.create');
Route::resource('devices', DeviceController::class);
