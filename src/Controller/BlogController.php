<?php

namespace App\Controller;

use Pimcore\Controller\FrontendController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bridge\Twig\Attribute\Template;

class BlogController extends FrontendController
{
    #[Template('blog/index.html.twig')]
    public function indexAction(Request $request)
    {
        return [];
    }

}
