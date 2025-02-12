<?php

namespace Sherlockode\SyliusAdvancedContentPlugin\EventListener;

use Doctrine\ORM\EntityManagerInterface;
use Sherlockode\AdvancedContentBundle\Manager\ConfigurationManager;
use Sherlockode\AdvancedContentBundle\Model\VersionInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Contracts\Translation\TranslatorInterface;

class AdminVersionListener
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
     * @var ConfigurationManager
     */
    private $configurationManager;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @param RequestStack           $requestStack
     * @param TranslatorInterface    $translator
     * @param ConfigurationManager   $configurationManager
     * @param EntityManagerInterface $em
     */
    public function __construct(
        RequestStack $requestStack,
        TranslatorInterface $translator,
        ConfigurationManager $configurationManager,
        EntityManagerInterface $em
    ) {
        $this->requestStack = $requestStack;
        $this->translator = $translator;
        $this->configurationManager = $configurationManager;
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
        $request = $this->requestStack->getMainRequest();
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

        $this->requestStack->getSession()->getFlashBag()
            ->add('info', $this->translator->trans('sherlockode_sylius_acb.form.version_edit', [
                '%version%' => $version->getId(),
                '%date%' => $formatter->format($version->getCreatedAt()),
            ]))
        ;
    }
}
