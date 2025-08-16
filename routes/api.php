<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{
    RoomTypeController, FacilityController, PolicyController,
    PageController, BookingController, ContactController
};

Route::get('/room-types', [RoomTypeController::class, 'index']);
Route::get('/room-types/{slug}', [RoomTypeController::class, 'show']);

Route::get('/facilities', [FacilityController::class, 'index']);
Route::get('/policies', [PolicyController::class, 'index']);
Route::get('/pages/{slug}', [PageController::class, 'show']);
Route::get('/bookings', [BookingController::class, 'index']);
Route::get('/availability', [BookingController::class, 'availability']);
Route::post('/bookings', [BookingController::class, 'store']);

Route::post('/contact', [ContactController::class, 'store']);

