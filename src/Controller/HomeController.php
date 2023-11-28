<?php

namespace App\Controller;

use Pimcore\Controller\FrontendController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bridge\Twig\Attribute\Template;

class HomeController extends FrontendController
{
    #[Template('home/index.html.twig')]
    public function homeAction(Request $request)
    {
        return [];
    }

}
