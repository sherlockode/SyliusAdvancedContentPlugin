<?php

namespace Sherlockode\SyliusAdvancedContentPlugin\EventListener;

use Sherlockode\AdvancedContentBundle\Manager\ConfigurationManager;
use Sherlockode\SyliusAdvancedContentPlugin\Scope\ScopeInitializer;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Contracts\Translation\TranslatorInterface;

class AdminGridListener
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var ScopeInitializer
     */
    private $scopeInitializer;

    /**
     * @var ConfigurationManager
     */
    private $configurationManager;

    /**
     * @param RequestStack         $requestStack
     * @param TranslatorInterface  $translator
     * @param ScopeInitializer     $scopeInitializer
     * @param ConfigurationManager $configurationManager
     */
    public function __construct(
        RequestStack $requestStack,
        TranslatorInterface $translator,
        ScopeInitializer $scopeInitializer,
        ConfigurationManager $configurationManager
    ) {
        $this->requestStack = $requestStack;
        $this->translator = $translator;
        $this->scopeInitializer = $scopeInitializer;
        $this->configurationManager = $configurationManager;
    }

    /**
     * @param GenericEvent $event
     */
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
