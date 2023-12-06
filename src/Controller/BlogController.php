<?php

namespace App\Controller;

use Pimcore\Controller\FrontendController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bridge\Twig\Attribute\Template;
use App\Website\LinkGenerator\BlogPostLinkGenerator;
use Pimcore\Model\DataObject\BlogPost;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;


class BlogController extends FrontendController
{
    #[Template('blog/index.html.twig')]
    public function indexAction(Request $request)
    {
        return [];
    }

    /**
     * @Route("/blog/{blogtitle}~n{blogpost}", name="blog_post-detail", defaults={"blog"=""}, requirements={"blog"=".*?", "blogtitle"="[\w-]+", "blogpost"="\d+"})
     */
    public function detailAction(Request $request, BlogPostLinkGenerator $blogPostLinkGenerator): \Symfony\Component\HttpFoundation\Response
    {
        $blogpost = BlogPost::getById($request->get('blogpost'));

        if (!($blogpost instanceof BlogPost && ($blogpost->isPublished() || $this->verifyPreviewRequest($request, $blogpost)))) {
            throw new NotFoundHttpException('News not found.');
        }


        return $this->render('blog/detail.html.twig', [
            'blogpost' => $blogpost
        ]);
    }


}
