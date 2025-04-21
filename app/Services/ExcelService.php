<?php

namespace App\Services;

use App\Exports\WeatherForecastExport;
use Maatwebsite\Excel\Facades\Excel;

class ExcelService
{
    public static function generateWeatherForecastExcel(string $country, string $city, array $data)
    {
        $filename = "{$country}_{$city}_weather.xlsx";
        return Excel::download(new WeatherForecastExport($city, $country, $data), $filename);
    }
}
