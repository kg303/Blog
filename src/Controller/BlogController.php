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
     * @Route ("/blog/{blogtitle}-{blogpost}", name="blog_post-detail", requirements={"blogtitle"="[\w-]+", "blogpost"="\d+"})
     */
    public function detailAction(Request $request, BlogPostLinkGenerator $blogPostLinkGenerator): \Symfony\Component\HttpFoundation\Response
    {
        $blogPosts = BlogPost::getById($request->get('blogpost'));

        if (!($blogPosts instanceof BlogPost && ($blogPosts->isPublished() || $this->verifyPreviewRequest($request, $blogPosts)))) {
            throw new NotFoundHttpException('News not found.');
        }


        return $this->render('blog/detail.html.twig', [
            'blogPosts' => $blogPosts
        ]);
    }


}
