<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Exception;

class CityService
{
    public function fetchAll($countrySlug)
    {
        try {
            $path = public_path('data/cities.json');

            if (!$this->fileExists($path)) {
                return [];
            }

            $cities = $this->getCitiesFromFile($path);

            if (!$cities) {
                return [];
            }

            $filteredCities = $this->filterCitiesByCountry($cities, $countrySlug);
            $sortedCities = $this->sortCitiesByName($filteredCities);

            return $this->reindexCities($sortedCities);
        } catch (Exception $e) {
            Log::error('Error in CityService fetchAll method: ' . $e->getMessage());

            return [];
        }
    }

    private function fileExists($path)
    {
        return file_exists($path);
    }

    private function getCitiesFromFile($path)
    {
        $fileContents = file_get_contents($path);
        $cities = json_decode($fileContents, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return null;
        }

        return $cities;
    }

    private function filterCitiesByCountry($cities, $countrySlug)
    {
        return array_filter($cities, function ($city) use ($countrySlug) {
            return strtolower($city['country']) === strtolower($countrySlug);
        });
    }

    private function sortCitiesByName($cities)
    {
        usort($cities, function ($a, $b) {
            return strcasecmp($a['name'], $b['name']);
        });

        return $cities;
    }

    private function reindexCities($cities)
    {
        return array_values($cities);
    }
}
