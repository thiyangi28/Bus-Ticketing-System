<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BusController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('buses', BusController::class);
