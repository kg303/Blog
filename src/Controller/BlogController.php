<?php

namespace App\Controller;

use App\Website\LinkGenerator\BlogPostLinkGenerator;
use Knp\Component\Pager\PaginatorInterface;
use Pimcore\Model\DataObject\BlogPost;
use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Pimcore\Controller\FrontendController;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends FrontendController
{

    public function listingAction(Request $request, PaginatorInterface $paginator): Response
    {
        // get a list of blog post objects and order them by date
        $blogPostList = new BlogPost\Listing();
        $blogPostList->setOrderKey('date');
        $blogPostList->setOrder('DESC');

        $paginator = $paginator->paginate(
            $blogPostList,
            $request->get('page', 1),
            1
        );

        return $this->render('blog/index.html.twig', [
            'blogpost' => $paginator,
            'paginationVariables' => $paginator->getPaginationData(),
        ]);
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
