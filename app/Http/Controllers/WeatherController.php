<?php

namespace App\Http\Controllers;

use App\Services\CountryService;
use App\Services\WeatherService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use App\Exports\WeatherForecastExport;
use App\Services\ExcelService;
use Maatwebsite\Excel\Facades\Excel;

class WeatherController extends Controller
{
    protected $weatherService;
    protected $countryService;

    public function __construct(WeatherService $weatherService, CountryService $countryService)
    {
        $this->weatherService = $weatherService;
        $this->countryService = $countryService;
    }

    public function show($country, $city, Request $request)
    {
        if (!$this->validateCountryAndCity($country, $city)) {
            return redirect()->route('home');
        }

        $selectedDate = $request->query('date');
        $selectedTime = $request->query('time');

        $data = $this->getWeatherData($city, $selectedDate, $selectedTime);

        if (!$data) {
            return redirect()->route('home')->with('error', 'City not found.');
        }

        return $this->renderWeatherPage($data, $country, $city);
    }

    private function validateCountryAndCity($country, $city)
    {
        return $country && $city;
    }

    private function getWeatherData($city, $selectedDate, $selectedTime)
    {
        $formattedCity = str_replace('-', ' ', $city);
        return $this->weatherService->getForecastForCity($formattedCity, $selectedDate, $selectedTime);
    }

    private function renderWeatherPage($data, $country, $city)
    {
        return Inertia::render('Weather/Show', [
            'success' => true,
            'icon' => $data['icon'],
            'description' => $data['description'],
            'temperature' => $data['temperatureCelsius'],
            'country' => $country,
            'city' => $data['city'],
            'date' => $data['date'],
            'time' => $data['time'],
            'days' => $data['days'],
            'times' => $data['times'],
        ]);
    }

    public function download($country, $city)
    {
        $result = $this->weatherService->getAllForecastsForCity($city);

        if (!$result['success']) {
            return response()->json(['error' => 'Unable to fetch weather data'], 500);
        }

        return ExcelService::generateWeatherForecastExcel($country, $city, $result['forecasts']->toArray());
    }
}
