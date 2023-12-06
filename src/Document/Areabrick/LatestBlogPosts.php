<?php

namespace App\Document\Areabrick;

use Pimcore\Model\DataObject\BlogPost;
use Pimcore\Model\Document\Editable\Area\Info;
use Symfony\Component\Httpfoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LatestBlogPosts extends AbstractAreabrick
{
    public function getName(): string
    {
        return 'Latest Blog Posts';
    }

    public function action(Info $info): ?\Symfony\Component\HttpFoundation\Response
    {
        $blogPosts = new BlogPost\Listing();
        $blogPosts->setOrderKey('date');
        $blogPosts->setOrder('desc');
        $blogPosts->setLimit(3);

        $info->setParams(
            [
                'blogpost' => $blogPosts
            ]
        );

        return null;
    }

}
