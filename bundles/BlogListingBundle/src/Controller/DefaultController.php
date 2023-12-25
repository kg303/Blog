<?php

namespace BlogListingBundle\Controller;

use Pimcore\Controller\FrontendController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Pimcore\Model\DataObject\BlogPost;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends FrontendController
{
    /**
     * @Route("/blog_listing")
     */
    public function indexAction(Request $request): Response
    {
        $blogposts = new BlogPost\Listing;
        $blogposts->setOrderKey('creationDate');
        $blogposts->setOrder('desc');

        return $this->render('blog/listing.html.twig', [
            'blogposts' => $blogposts,
        ]);
    }
}
