<?php

namespace App\Controller;

use App\Service\SearchService;
use Pimcore\Controller\FrontendController;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends FrontendController
{
    private SearchService $searchService;

    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }

    public function searchAction(Request $request)
    {
        // Example: Get the search query from the request
        $query = $request->get('query');

        // Perform the search using the generic search service
        $results = $this->searchService->search($query);

        // Return the search results or render a template with the results
        return $this->render('search/results.html.twig', [
            'query' => $query,
            'results' => $results,
        ]);
    }
}
