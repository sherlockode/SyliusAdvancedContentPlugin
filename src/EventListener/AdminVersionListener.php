<?php

namespace Sherlockode\SyliusAdvancedContentPlugin\EventListener;

use Doctrine\ORM\EntityManagerInterface;
use Sherlockode\AdvancedContentBundle\Manager\ConfigurationManager;
use Sherlockode\AdvancedContentBundle\Model\VersionInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Contracts\Translation\TranslatorInterface;

class AdminVersionListener
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
     * @var ConfigurationManager
     */
    private $configurationManager;

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @param Session                $session
     * @param TranslatorInterface    $translator
     * @param ConfigurationManager   $configurationManager
     * @param RequestStack           $requestStack
     * @param EntityManagerInterface $em
     */
    public function __construct(
        Session $session,
        TranslatorInterface $translator,
        ConfigurationManager $configurationManager,
        RequestStack $requestStack,
        EntityManagerInterface $em
    ) {
        $this->session = $session;
        $this->translator = $translator;
        $this->configurationManager = $configurationManager;
        $this->requestStack = $requestStack;
        $this->em = $em;
    }

    public function editContentVersionMessage(): void
    {
        $this->addVersionMessage('content_version');
    }

    public function editPageVersionMessage(): void
    {
        $this->addVersionMessage('page_version');
    }

    /**
     * @param string $entityClass
     */
    private function addVersionMessage(string $entityClass): void
    {
        $request = $this->getRequest();
        if ($request === null) {
            return;
        }

        $versionId = $request->get('versionId');
        if ($versionId === null) {
            return;
        }

        /** @var VersionInterface $version */
        $version = $this->em->getRepository($this->configurationManager->getEntityClass($entityClass))->find($versionId);
        if ($version === null) {
            return;
        }

        $formatter = \IntlDateFormatter::create(
            $request->getLocale(),
            \IntlDateFormatter::MEDIUM,
            \IntlDateFormatter::MEDIUM
        );

        $this->session->getFlashBag()->add('info', $this->translator->trans('sherlockode_sylius_acb.form.version_edit', [
            '%version%' => $version->getId(),
            '%date%' => $formatter->format($version->getCreatedAt()),
        ]));
    }

    /**
     * @return Request|null
     */
    private function getRequest(): ?Request
    {
        if (method_exists($this->requestStack, 'getMainRequest')) {
            // SF >= 5.3
            return $this->requestStack->getMainRequest();
        }

        // compat SF < 5.3
        return $this->requestStack->getMasterRequest();
    }
}
