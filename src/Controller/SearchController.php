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

        $query = $request->get('query');


        $results = $this->searchService->search($query);


        return $this->render('search/results.html.twig', [
            'query' => $query,
            'results' => $results,
        ]);
    }
}
