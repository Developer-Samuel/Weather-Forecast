<?php

namespace App\Services;

use Illuminate\Support\Facades\File;

class SearchService
{
    public function search($query)
    {
        $query = strtolower(trim($query));
        $results = [];
        $existingNames = [];

        if (!empty($query)) {
            $countries = $this->loadData('countries');
            $cities = $this->loadData('cities');

            $matchedCountries = $this->searchCountries($countries, $query, $existingNames);
            $matchedCities = $this->searchCities($cities, $query, $existingNames);

            $results = array_merge($matchedCountries, $matchedCities);
        }

        return $results;
    }

    private function loadData($type)
    {
        $path = public_path('data/' . $type . '.json');
        $json = File::get($path);
        return json_decode($json, true);
    }

    private function searchCountries($countries, $query, &$existingNames)
    {
        $matchedCountries = [];

        foreach ($countries as $country) {
            if (!isset($country['name'])) {
                continue;
            }

            $countryName = strtolower(trim($country['name']));
            if ($this->matchesQuery($countryName, $query, $existingNames)) {
                $matchedCountries[] = [
                    'type' => 'country',
                    'url' => url('/weather/' . urlencode($country['name']) . '/' . urlencode($country['name'])),
                    'name' => $country['name'],
                ];
            }
        }

        return $matchedCountries;
    }

    private function searchCities($cities, $query, &$existingNames)
    {
        $matchedCities = [];

        foreach ($cities as $city) {
            if (!isset($city['name']) || !isset($city['country'])) {
                continue;
            }

            $cityName = strtolower(trim($city['name']));
            if ($this->matchesQuery($cityName, $query, $existingNames)) {
                $matchedCities[] = [
                    'type' => 'city',
                    'url' => url('/weather/' . urlencode($city['country']) . '/' . urlencode($city['name'])),
                    'name' => $city['name'],
                    'country' => $city['country'],
                ];
            }
        }

        return $matchedCities;
    }

    private function matchesQuery($name, $query, &$existingNames)
    {
        if (str_contains($name, $query) && !in_array($name, $existingNames)) {
            $existingNames[] = $name;
            return true;
        }

        return false;
    }
}