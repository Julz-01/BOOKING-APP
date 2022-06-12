<?php

use App\Http\Controllers\BookingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TourController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('tour')->group(function () {
    Route::controller(TourController::class)->group(function () {
        //Tours Route
        Route::post('/', 'store');
        Route::get('/', 'findTours');
        Route::get('/{id}', 'findTour');
        Route::post('/{id}', 'updateTour');
        //Tour Dates Route
        Route::get('/date/{id}', 'findTourDates');
        Route::patch('/disable/{id}', 'disableTourDate');
        Route::patch('/enable/{id}', 'enableTourDate');
    });
});

Route::prefix('booking')->group(function () {
    Route::controller(BookingController::class)->group(function () {
        //Booking Routes
        Route::post('/', 'store');
        Route::get('/', 'findAll');
        Route::get('/{id}', 'findBooking');
        Route::get('/date/{id}', 'findBookingDates');
        Route::get('/passengers/{id}', 'findBookingPassengers');
        Route::delete('/passenger/{id}', 'removeBookingPassengers');
        Route::post('/update/{id}', 'updateBooking');
    });
});
