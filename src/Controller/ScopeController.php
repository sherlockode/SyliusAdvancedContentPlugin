<?php

namespace Sherlockode\SyliusAdvancedContentPlugin\Controller;

use Sherlockode\AdvancedContentBundle\Manager\ConfigurationManager;
use Sherlockode\SyliusAdvancedContentPlugin\Scope\ScopeInitializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;

class ScopeController extends AbstractController
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
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @param ConfigurationManager $configurationManager
     * @param ScopeInitializer     $scopeInitializer
     * @param TranslatorInterface  $translator
     */
    public function __construct(
        ConfigurationManager $configurationManager,
        ScopeInitializer $scopeInitializer,
        TranslatorInterface $translator
    ) {
        $this->configurationManager = $configurationManager;
        $this->scopeInitializer = $scopeInitializer;
        $this->translator = $translator;
    }

    /**
     * @return Response
     */
    public function updateScopesAction()
    {
        if (!$this->configurationManager->isScopesEnabled()) {
            $this->addFlash('error', $this->translator->trans('sherlockode_sylius_acb.scopes.disabled'));

            return $this->redirectToRoute('sherlockode_acb_tools_index');
        }

        if (!$this->scopeInitializer->hasMissingScopes()) {
            $this->addFlash('info', $this->translator->trans('sherlockode_sylius_acb.scopes.up_to_date'));

            return $this->redirectToRoute('sherlockode_acb_tools_index');
        }

        try {
            $this->scopeInitializer->init();
            $this->addFlash('success', $this->translator->trans('sherlockode_sylius_acb.scopes.init_success'));
        } catch (\Exception $e) {
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('sherlockode_acb_tools_index');
    }
}
