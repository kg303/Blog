<?php

namespace App\MetaData\Extractor;

use App\Website\LinkGenerator\BlogPostLinkGenerator;
use Pimcore\Model\DataObject\BlogPost;
use Pimcore\Tool;
use SeoBundle\MetaData\Extractor\ExtractorInterface;
use SeoBundle\Model\SeoMetaDataInterface;

class ArticleExtractor implements ExtractorInterface
{
    /**
     * @var BlogPostLinkGenerator
     */
    protected BlogPostLinkGenerator $blogPostLinkGenerator;

    /**
     * NewsExtension constructor.
     *
     * @param BlogPostLinkGenerator $blogPostLinkGenerator
     */
    public function __construct(BlogPostLinkGenerator $blogPostLinkGenerator)
    {
        $this->blogPostLinkGenerator = $blogPostLinkGenerator;
    }

    public function supports(mixed $element): bool
    {
        return $element instanceof BlogPost;
    }

    public function updateMetaData($element, ?string $locale, SeoMetaDataInterface $seoMetadata): void
    {
        $seoMetadata->setTitle(($element->getTitle() ?? '') . ' | Project');
        $seoMetadata->setMetaDescription(strip_tags($element->getShortDescription()));
        $seoMetadata->addExtraProperty('og:type', 'website');
        $seoMetadata->addExtraProperty('og:url', Tool::getHostUrl() . $this->blogPostLinkGenerator->generate($element));
        $seoMetadata->addExtraProperty('og:title', $element->getTitle() . ' | Project');
        $seoMetadata->addExtraProperty('og:description', strip_tags($element->getShortDescription()));

        $seoMetadata->addExtraProperty('twitter:card', 'summary_large_image');
        $seoMetadata->addExtraProperty('twitter:title', $element->getTitle() . ' | Project');
        $seoMetadata->addExtraProperty('twitter:description', strip_tags($element->getShortDescription()));

        $ogImage = '';

        if($image = $element->getImage()) {
            $ogImage = Tool::getHostUrl() . $image->getThumbnail('social_thumb');
        }

        $seoMetadata->addExtraProperty('og:image', $ogImage);
        $seoMetadata->addExtraProperty('twitter:image', $ogImage);
    }
}
