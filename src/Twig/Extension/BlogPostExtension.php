<?php


namespace App\Twig\Extension;

use App\Website\LinkGenerator\BlogPostLinkGenerator;
use Pimcore\Model\DataObject\BlogPost;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class BlogPostExtension extends AbstractExtension
{
    /**
     * @var BlogPostLinkGenerator
     */
    protected $blogPostLinkGenerator;

    /**
     * BlogPostExtension constructor.
     *
     * @param BlogPostLinkGenerator $blogPostLinkGenerator
     */
    public function __construct(BlogPostLinkGenerator $blogPostLinkGenerator)
    {
        $this->blogPostLinkGenerator = $blogPostLinkGenerator;
    }

    /**
     * @return TwigFunction[]
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('app_news_detaillink', [$this, 'generateLink']),
        ];
    }

    /**
     * @param BlogPost $blogPosts
     *
     * @return string
     */
    public function generateLink(BlogPost $blogPosts): string
    {
        return $this->blogPostLinkGenerator->generate($blogPosts, []);
    }
}
