<?php


namespace App\Website\LinkGenerator;


use Pimcore\Http\Request\Resolver\DocumentResolver;
use Pimcore\Localization\LocaleServiceInterface;
use Pimcore\Model\DataObject;
use Pimcore\Model\DataObject\ClassDefinition\LinkGeneratorInterface;
use Pimcore\Model\DataObject\BlogPost;
use Pimcore\Model\Document;
use App\Website\Tool\Text;
use Pimcore\Twig\Extension\Templating\PimcoreUrl;
use Symfony\Component\HttpFoundation\RequestStack;

class BlogPostLinkGenerator implements LinkGeneratorInterface
{
    /**
     * @var DocumentResolver
     */
    protected $documentResolver;

    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * @var PimcoreUrl
     */
    protected $pimcoreUrl;

    /**
     * @var LocaleServiceInterface
     */
    protected $localeService;

    /**
     * NewsLinkGenerator constructor.
     *
     * @param DocumentResolver $documentResolver
     * @param RequestStack $requestStack
     * @param PimcoreUrl $pimcoreUrl
     * @param LocaleServiceInterface $localeService
     */
    public function __construct(DocumentResolver $documentResolver, RequestStack $requestStack, PimcoreUrl $pimcoreUrl, LocaleServiceInterface $localeService)
    {
        $this->documentResolver = $documentResolver;
        $this->requestStack = $requestStack;
        $this->pimcoreUrl = $pimcoreUrl;
        $this->localeService = $localeService;
    }

    public function generate(object $object, array $params = []): string
    {
        if (!($object instanceof BlogPost)) {
            throw new \InvalidArgumentException('Given object is no News');
        }

        return DataObject\Service::useInheritedValues(true, function () use ($object, $params) {
            $fullPath = '';

            if (isset($params['document']) && $params['document'] instanceof Document) {
                $document = $params['document'];
            } else {
                $document = $this->documentResolver->getDocument($this->requestStack->getCurrentRequest());
            }

            $localeUrlPart = '/' . $this->localeService->getLocale() . '/';
            if ($document && $localeUrlPart !== $document->getFullPath()) {
                $fullPath = substr($document->getFullPath(), strlen($localeUrlPart));
            }

//            if ($document && !$fullPath) {
//                $fullPath = $document->getProperty('blog_post_default_document') ? substr($document->getProperty('blog_post_default_document')->getFullPath(), strlen($localeUrlPart)) : '';
//            }

            $locale = $params['locale'] ?? null;

            return $this->pimcoreUrl->__invoke(
                [
                    'blogtitle' => Text::toUrl($object->getTitle($locale) ? $object->getTitle($locale) : 'blogpost'),
                    'blogpost' => $object->getId(),
                    'blog' => $fullPath,
                    '_locale' => $locale,
                ],

                    'blog_post-detail',
                    true
            );
        });
    }
}
