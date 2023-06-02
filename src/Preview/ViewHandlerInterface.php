<?php

namespace Sherlockode\SyliusAdvancedContentPlugin\Preview;

use Sherlockode\AdvancedContentBundle\Model\PageInterface;
use Sherlockode\AdvancedContentBundle\Model\ScopeInterface;

interface ViewHandlerInterface
{
    /**
     * @param PageInterface  $page
     * @param ScopeInterface $scope
     *
     * @return string|null
     */
    public function getViewTemplate(PageInterface $page, ScopeInterface $scope): ?string;
}

