<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;

class WeatherService
{
    private string $baseUrl;
    private string $apiKey;
    private DateService $dateService;

    public function __construct(DateService $dateService)
    {
        $this->baseUrl = config('weather.url');
        $this->apiKey = config('weather.key');
        $this->dateService = $dateService;
    }

    public function getForecastForCity(string $city, ?string $targetDate = null, ?string $targetTime = null): array
    {
        $response = $this->fetchWeatherData($city);

        if (!$response['success']) {
            return $this->buildErrorResponse();
        }

        $forecastList = collect($response['data']['list']);
        $firstForecast = $forecastList->first();

        [$selectedDate, $selectedTime] = $this->resolveDateTime($firstForecast, $targetDate, $targetTime);
        $selectedForecast = $this->findForecastOrDefault($forecastList, $selectedDate, $selectedTime, $firstForecast);

        return $this->buildForecastResponse($city, $response['data'], $forecastList, $selectedForecast, $selectedDate, $selectedTime);
    }

    public function getAllForecastsForCity(string $city): array
    {
        $response = $this->fetchWeatherData($city);

        if (!$response['success']) {
            return [
                'success' => false,
                'city' => $city,
                'forecasts' => collect(),
            ];
        }

        $forecasts = $this->transformAllForecasts(collect($response['data']['list']));

        return [
            'success' => true,
            'city' => $city,
            'forecasts' => $forecasts,
        ];
    }

    private function fetchWeatherData(string $city): array
    {
        $url = "{$this->baseUrl}&appid={$this->apiKey}&q=" . urlencode($city);
        $response = Http::get($url);

        if (!$response->successful() || !isset($response['list'])) {
            return ['success' => false, 'data' => null];
        }

        return ['success' => true, 'data' => $response->json()];
    }

    private function resolveDateTime(array $firstForecast, ?string $targetDate, ?string $targetTime): array
    {
        [$defaultDate, $defaultTime] = DateService::getDateTimeParts($firstForecast['dt_txt']);

        $selectedDate = $this->dateService::formatDate($targetDate) ?? $defaultDate;
        $selectedTime = $this->dateService::formatTime($targetTime) ?? $defaultTime;

        return [$selectedDate, $selectedTime];
    }

    private function findForecastOrDefault(Collection $forecasts, string $date, string $time, array $default): array
    {
        return $this->findForecastByDateTime($forecasts, $date, $time) ?? $default;
    }

    private function buildForecastResponse(
        string $city,
        array $data,
        Collection $forecastList,
        array $forecast,
        string $date,
        string $time
    ): array {
        return [
            'success' => true,
            'data' => $data,
            'icon' => $forecast['weather'][0]['icon'] ?? null,
            'description' => $forecast['weather'][0]['description'] ?? null,
            'temperatureCelsius' => $this->kelvinToCelsius($forecast['main']['temp'] ?? null),
            'city' => $city,
            'date' => $date,
            'time' => $time,
            'days' => $this->extractForecastDays($forecastList),
            'times' => $this->extractForecastTimes($forecastList, $date),
        ];
    }

    private function findForecastByDateTime(Collection $forecasts, string $date, string $time): ?array
    {
        return $forecasts->first(function ($item) use ($date, $time) {
            if (!isset($item['dt_txt'])) return false;
            [$itemDate, $itemTime] = DateService::getDateTimeParts($item['dt_txt']);
            return $itemDate === $date && $itemTime === $time;
        });
    }

    private function extractForecastTimes(Collection $forecasts, string $selectedDate): Collection
    {
        return $forecasts
            ->filter(fn($item) => explode(' ', $item['dt_txt'])[0] === $selectedDate)
            ->map(fn($item) => [
                'time' => explode(' ', $item['dt_txt'])[1],
                'temperature' => $this->kelvinToCelsius($item['main']['temp'] ?? null),
                'description' => $item['weather'][0]['description'] ?? null,
                'icon' => $item['weather'][0]['icon'] ?? null,
            ])
            ->values();
    }

    private function extractForecastDays(Collection $forecasts): Collection
    {
        return $forecasts
            ->pluck('dt_txt')
            ->map(fn($dt) => explode(' ', $dt)[0])
            ->unique()
            ->values()
            ->map(fn($day) => [
                'date' => $day,
                'label' => $this->dateService::getLabelForDate($day),
            ]);
    }

    private function transformAllForecasts(Collection $forecasts): Collection
    {
        return $forecasts->map(function ($item) {
            [$date, $time] = DateService::getDateTimeParts($item['dt_txt']);
            return [
                'date' => $date,
                'time' => $time,
                'temperature' => $this->kelvinToCelsius($item['main']['temp'] ?? null),
                'description' => $item['weather'][0]['description'] ?? null,
            ];
        });
    }

    private function kelvinToCelsius(?float $kelvin): ?float
    {
        return isset($kelvin) ? round($kelvin - 273.15, 1) : null;
    }

    private function buildErrorResponse(): array
    {
        return [
            'success' => false,
            'data' => null,
            'icon' => null,
            'description' => null,
            'temperatureCelsius' => null,
            'city' => null,
            'date' => null,
            'time' => null,
            'days' => [],
            'times' => [],
        ];
    }
}
