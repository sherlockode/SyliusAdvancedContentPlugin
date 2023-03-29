<?php

namespace Sherlockode\SyliusAdvancedContentPlugin\Twig\Extension;

use Sherlockode\AdvancedContentBundle\Manager\ConfigurationManager;
use Sherlockode\SyliusAdvancedContentPlugin\Scope\ScopeInitializer;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ScopeExtension extends AbstractExtension
{
    /**
     * @var ConfigurationManager
     */
    private $configurationManager;

    /**
     * @var ScopeInitializer
     */
    private $scopeInitializer;

    /**
     * @param ConfigurationManager $configurationManager
     * @param ScopeInitializer     $scopeInitializer
     */
    public function __construct(
        ConfigurationManager $configurationManager,
        ScopeInitializer $scopeInitializer
    ) {
        $this->configurationManager = $configurationManager;
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
            new TwigFunction('sylius_acb_is_scopes_enabled', [$this, 'isScopesEnabled']),
            new TwigFunction('sylius_acb_is_scopes_up_to_date', [$this, 'isScopesUpToDate']),
        ];
    }

    /**
     * @return bool
     */
    public function isScopesEnabled(): bool
    {
        return $this->configurationManager->isScopesEnabled();
    }

    /**
     * @return bool
     */
    public function isScopesUpToDate(): bool
    {
        return !$this->scopeInitializer->hasMissingScopes();
    }
}
