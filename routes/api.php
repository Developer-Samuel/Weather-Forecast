<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherController;

Route::prefix('api')->group(function () {
    Route::get('/weather/{country}/{city}/download', [WeatherController::class, 'download'])->name('weather.download');
});