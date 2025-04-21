<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class CountryService
{
    public function fetchAll(): ?array
    {
        try {
            $path = public_path('data/countries.json');

            if (!file_exists($path)) {
                return null;
            }

            $fileContents = file_get_contents($path);
            $countries = json_decode($fileContents, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return null;
            }

            return $countries;
        } catch (Exception $e) {
            Log::error('Error in CountryService fetchAll method: ' . $e->getMessage());

            return null;
        }
    }

    public function fetchAllFromApi(): ?array
    {
        try {
            $response = Http::get('https://countriesnow.space/api/v0.1/countries');

            if (!$response->successful()) {
                return null;
            }

            return $this->parseApiResponse($response->json()['data']);
        } catch (Exception $e) {
            Log::error('Error in CountryService fetchAllFromApi method: ' . $e->getMessage());

            return null;
        }
    }

    public function find(string $name): ?array
    {
        $countries = $this->fetchAll();

        if (!$countries) {
            return null;
        }

        $country = collect($countries)->first(fn($country) => $this->compareCountryName($country, $name));

        if ($country) {
            return $this->ensureSlug($country);
        }

        return null;
    }

    public function saveToFile($countries)
    {
        $path = public_path('data/countries.json');

        try {
            file_put_contents($path, json_encode($countries, JSON_PRETTY_PRINT));
            return true;
        } catch (Exception $e) {
            Log::error('Error in CountryService saveToFile method: ' . $e->getMessage());

            return false;
        }
    }

    private function parseApiResponse(array $data): array
    {
        return collect($data)
            ->filter(fn($country) => isset($country['iso2'], $country['country']))
            ->map(fn($country) => [
                'slug' => $country['iso2'],
                'name' => $country['country'],
            ])
            ->sortBy(fn($country) => $country['name'])
            ->values()
            ->toArray();
    }

    private function compareCountryName(array $country, string $name): bool
    {
        return strtolower($country['name']) === strtolower($name);
    }

    private function ensureSlug(array $country): array
    {
        if (!isset($country['slug'])) {
            $country['slug'] = strtolower(str_replace(' ', '-', $country['name']));
        }

        return $country;
    }
}
