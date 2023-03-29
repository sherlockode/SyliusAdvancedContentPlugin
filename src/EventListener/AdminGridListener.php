<?php

namespace Sherlockode\SyliusAdvancedContentPlugin\EventListener;

use Sherlockode\AdvancedContentBundle\Manager\ConfigurationManager;
use Sherlockode\SyliusAdvancedContentPlugin\Scope\ScopeInitializer;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Contracts\Translation\TranslatorInterface;

class AdminGridListener
{
    /**
     * @var Session
     */
    private $session;

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
     * @param Session              $session
     * @param TranslatorInterface  $translator
     * @param ScopeInitializer     $scopeInitializer
     * @param ConfigurationManager $configurationManager
     */
    public function __construct(
        Session $session,
        TranslatorInterface $translator,
        ScopeInitializer $scopeInitializer,
        ConfigurationManager $configurationManager
    ) {
        $this->session = $session;
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

        $this->session->getFlashBag()->add('info', $this->translator->trans('sherlockode_sylius_acb.scopes.missing_scopes'));
    }
}
