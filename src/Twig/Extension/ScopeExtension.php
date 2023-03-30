<?php

namespace Sherlockode\SyliusAdvancedContentPlugin\Twig\Extension;

use Sherlockode\SyliusAdvancedContentPlugin\Scope\ScopeInitializer;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ScopeExtension extends AbstractExtension
{
    /**
     * @var ScopeInitializer
     */
    private $scopeInitializer;

    /**
     * @param ScopeInitializer $scopeInitializer
     */
    public function __construct(
        ScopeInitializer $scopeInitializer
    ) {
        $this->scopeInitializer = $scopeInitializer;
    }

    /**
     * Add specific twig function
     *
     * @return TwigFunction[]
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('sylius_acb_is_scopes_up_to_date', [$this, 'isScopesUpToDate']),
        ];
    }

    /**
     * @return bool
     */
    public function isScopesUpToDate(): bool
    {
        return !$this->scopeInitializer->hasMissingScopes();
    }
}
