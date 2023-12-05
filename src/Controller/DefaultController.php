<?php

namespace App\Controller;

use Pimcore\Bundle\AdminBundle\Controller\Admin\LoginController;
use Pimcore\Controller\FrontendController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Component\Routing\Annotation\Route;
use Pimcore\Model\DataObject\BlogPost;

class DefaultController extends FrontendController
{

    /**
     * @Route("/testing-url", name="testing_url")
     */
    public function test()
    {
        $test = BlogPost::getById(3);

        dd($test);
    }


    /**
     * @param Request $request
     * @return Response
     */
    public function defaultAction(Request $request): Response
    {
        return $this->render('layouts/layout.html.twig');
    }

    /**
     * Forwards the request to admin login
     */
    public function loginAction(): Response
    {
        return $this->forward(LoginController::class.'::loginCheckAction');
    }

    #[Template('includes/footer.html.twig')]
    public function footerAction(Request $request)
    {
        return [];
    }

}
