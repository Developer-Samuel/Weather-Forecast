<?php

use App\Console\Commands\LoadCountries;
use Illuminate\Support\Facades\Artisan;

Artisan::command('countries:load', function () {
    $this->call(LoadCountries::class);
})->describe('Load countries from external API and store them in a JSON file');