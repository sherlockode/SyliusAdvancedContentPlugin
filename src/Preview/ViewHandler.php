<?php

namespace Sherlockode\SyliusAdvancedContentPlugin\Preview;

use Sherlockode\AdvancedContentBundle\Model\PageInterface;
use Sherlockode\AdvancedContentBundle\Model\ScopeInterface;

class ViewHandler implements ViewHandlerInterface
{
    /**
     * @param PageInterface  $page
     * @param ScopeInterface $scope
     *
     * @return string|null
     */
    public function getViewTemplate(PageInterface $page, ScopeInterface $scope): ?string
    {
        return '@SherlockodeSyliusAdvancedContentPlugin/Preview/preview.html.twig';
    }
}

