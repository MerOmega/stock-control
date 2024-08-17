<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/category', function () {
    return view('category');
});

Route::get('/supply', function () {
    return view('supply');
});

Route::get('/devices', function () {
    return view('devices');
});
