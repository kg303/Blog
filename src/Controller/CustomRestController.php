<?php

namespace App\Controller;

use Pimcore\Model\DataObject;
use Pimcore\Model\DataObject\BlogPost;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use \Pimcore\Controller\FrontendController;
use Pimcore\Model\DataObject\Service;
use Symfony\Component\HttpFoundation\Response;


class CustomRestController extends AbstractController
{
    /**
     * @Route("/rest/get-products")
     * @param Request $request
     * @return JsonResponse
     */
    public function defaultAction(Request $request): JsonResponse
    {
        // do some authorization here ...

        $blogs = new DataObject\BlogPost\Listing();

        foreach ($blogs as $key => $blog) {
            $data[] = array(
                "title" => $blog->getTitle(),
                "author" => $blog->getShortDescription(),
                "date" => $blog->getDate(),
                "posted_by" => $blog->getPostedBy());
        }

        return new JsonResponse($data);
    }
}
