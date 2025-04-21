<?php

use App\Http\Controllers\CountryController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\WeatherController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\HandleInertiaRequests;

require base_path('routes/api.php');

Route::get('/', [CountryController::class, 'index'])->name('home');
Route::get('/{country}', [CountryController::class, 'show'])->name('country');
Route::get('/search/find', [SearchController::class, 'index']);

Route::get('/weather/{country}/{city}', [WeatherController::class, 'show'])->name('city');

Route::get('/{any}', function () {
    return redirect('/');
})
->where('any', '.*')
->middleware(HandleInertiaRequests::class);
