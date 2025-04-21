<?php

namespace App\Console\Commands;

use App\Services\CountryService;
use Illuminate\Console\Command;

class LoadCountries extends Command
{
    protected $signature = 'countries:load';
    protected $description = 'Load countries from external API and store them in a JSON file';

    protected $countryService;

    public function __construct(CountryService $countryService)
    {
        parent::__construct();
        $this->countryService = $countryService;
    }

    public function handle()
    {
        $this->info('--- Starting country load process ---');

        $countries = $this->countryService->fetchAllFromApi();

        if (!$countries) {
            $this->error('❌ No countries fetched. API might have failed.');
            return;
        }

        $this->info('✅ Countries fetched successfully.');
        $this->info('🔢 Total countries: ' . count($countries));
        $this->info('📋 Sample of countries:');

        foreach (array_slice($countries, 0, 5) as $index => $country) {
            $this->line("  " . ($index + 1) . '. ' . $country['name'] . ' (' . $country['slug'] . ')');
        }

        $path = public_path('data/countries.json');
        $this->line("📁 Saving to file: $path");

        if ($this->countryService->saveToFile($countries)) {
            $this->info('✅ Countries saved successfully to countries.json');
        } else {
            $this->error('❌ Failed to save countries to file.');
        }

        $this->info('--- Country load process completed ---');
    }
}
