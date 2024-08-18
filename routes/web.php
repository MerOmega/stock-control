<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('categories', CategoryController::class);

Route::get('/supply', function () {
    return view('supply');
});

Route::get('/devices', function () {
    return view('devices');
});
