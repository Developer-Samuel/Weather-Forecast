<?php

namespace App\Http\Controllers;

use App\Services\SearchService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class SearchController extends Controller
{
    protected $searchService;

    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }

    public function index(Request $request)
    {
        $query = strtolower(trim($request->input('query')));

        $results = $this->searchService->search($query);

        return Inertia::render('Search/Index', [
            'results' => $results,
            'query' => $query,
        ]);
    }
}