<?php


namespace App\Website\Tool;

class PimcoreUrl extends \Pimcore\Twig\Extension\Templating\PimcoreUrl
{
    /**
     * @param array $urlOptions
     * @param null $name
     * @param bool $reset
     * @param bool $encode
     * @param bool $relative
     *
     * @return string
     */
    public function __invoke(array $urlOptions = [], $name = null, $reset = false, $encode = true, $relative = false): string
    {
        // merge all parameters from request to parameters
        if (!$reset && $this->requestHelper->hasMainRequest()) {
            $urlOptions = array_replace($this->requestHelper->getMainRequest()->attributes->get('_route_params', []), $urlOptions);
        }

        return parent::__invoke($urlOptions, $name, $reset, $encode, $relative);
    }
}
