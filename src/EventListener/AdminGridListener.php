<?php

declare(strict_types=1);

namespace Sherlockode\SyliusAdvancedContentPlugin\EventListener;

use Sherlockode\AdvancedContentBundle\Manager\ConfigurationManager;
use Sherlockode\SyliusAdvancedContentPlugin\Scope\ScopeInitializer;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Contracts\Translation\TranslatorInterface;

class AdminGridListener
{
    public function __construct(
        private readonly RequestStack $requestStack,
        private readonly TranslatorInterface $translator,
        private readonly ScopeInitializer $scopeInitializer,
        private readonly ConfigurationManager $configurationManager,
    ) {
    }

    public function checkScopeInitialization(GenericEvent $event): void
    {
        if (!$this->configurationManager->isScopesEnabled()) {
            return;
        }

        if (!$this->scopeInitializer->hasMissingScopes()) {
            return;
        }

        $this->requestStack->getSession()->getFlashBag()
            ->add('info', $this->translator->trans('sherlockode_sylius_acb.scopes.missing_scopes'))
        ;
    }
}
