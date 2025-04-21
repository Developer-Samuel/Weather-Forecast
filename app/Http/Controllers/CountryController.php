<?php

namespace App\Http\Controllers;

use App\Services\CityService;
use App\Services\CountryService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CountryController extends Controller
{
    protected $countryService;
    protected $cityService;

    public function __construct(
        CountryService $countryService,
        CityService $cityService,
    ) {
        $this->countryService = $countryService;
        $this->cityService = $cityService;

    }

    public function index()
    {
        $countries = $this->countryService->fetchAll();

        return Inertia::render('Countries/Index', [
            'countries' => $countries,
        ]);
    }

    public function show($name)
    {
        $country = $this->countryService->find($name);

        if (!$country) {
            return redirect()->route('home');
        }

        $cities = $this->cityService->fetchAll($country['slug']);

        return Inertia::render('Countries/Show', [
            'country' => $country['name'],
            'cities' => $cities,
        ]);
    }
}
