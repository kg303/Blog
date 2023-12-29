<?php

use Pimcore\Bundle\BundleGeneratorBundle\PimcoreBundleGeneratorBundle;
use Web2PrintToolsBundle\Web2PrintToolsBundle;
use Pimcore\Bundle\WebToPrintBundle\PimcoreWebToPrintBundle;
use Pimcore\Bundle\DataHubBundle\PimcoreDataHubBundle;




return [
    Pimcore\Bundle\ApplicationLoggerBundle\PimcoreApplicationLoggerBundle::class => ['all' => true],
    Pimcore\Bundle\CustomReportsBundle\PimcoreCustomReportsBundle::class => ['all' => true],
    Pimcore\Bundle\GlossaryBundle\PimcoreGlossaryBundle::class => ['all' => true],
    Pimcore\Bundle\SeoBundle\PimcoreSeoBundle::class => ['all' => true],
    Pimcore\Bundle\StaticRoutesBundle\PimcoreStaticRoutesBundle::class => ['all' => true],
    Pimcore\Bundle\TinymceBundle\PimcoreTinymceBundle::class => ['all' => true],
    Pimcore\Bundle\UuidBundle\PimcoreUuidBundle::class => ['all' => true],
    Pimcore\Bundle\WordExportBundle\PimcoreWordExportBundle::class => ['all' => true],
    \SeoBundle\SeoBundle::class => ['all' => true],
    PimcoreBundleGeneratorBundle::class => ['all' => true],
    BlogListingBundle\BlogListingBundle::class => ['all' => true],
    Web2PrintToolsBundle::class => ['all' => true],
    PimcoreWebToPrintBundle::class => ['all' => true],
    AdvancedObjectSearchBundle\AdvancedObjectSearchBundle::class => ['all' => true],
    PimcoreDataHubBundle::class => ['all' => true],
    Pimcore\Bundle\XliffBundle\PimcoreXliffBundle::class => ['all' => true],
];
