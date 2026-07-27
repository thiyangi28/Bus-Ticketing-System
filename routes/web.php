<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BusController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\BookingController;

Route::get('/', function () {
    return redirect()->route('buses.index');
});

Route::resource('buses', BusController::class);
Route::resource('routes', RouteController::class);
Route::resource('schedules', ScheduleController::class);
Route::resource('bookings', BookingController::class);
