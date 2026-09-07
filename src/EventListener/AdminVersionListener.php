<?php

declare(strict_types=1);

namespace Sherlockode\SyliusAdvancedContentPlugin\EventListener;

use Doctrine\ORM\EntityManagerInterface;
use Sherlockode\AdvancedContentBundle\Manager\ConfigurationManager;
use Sherlockode\AdvancedContentBundle\Model\VersionInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Contracts\Translation\TranslatorInterface;

class AdminVersionListener
{
    public function __construct(
        private readonly RequestStack $requestStack,
        private readonly TranslatorInterface $translator,
        private readonly ConfigurationManager $configurationManager,
        private readonly EntityManagerInterface $em,
    ) {
    }

    public function editContentVersionMessage(): void
    {
        $this->addVersionMessage('content_version');
    }

    public function editPageVersionMessage(): void
    {
        $this->addVersionMessage('page_version');
    }

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

        /** @var VersionInterface|null $version */
        $version = $this->em->getRepository($this->configurationManager->getEntityClass($entityClass))->find($versionId);
        if ($version === null) {
            return;
        }

        $formatter = \IntlDateFormatter::create(
            $request->getLocale(),
            \IntlDateFormatter::MEDIUM,
            \IntlDateFormatter::MEDIUM,
        );

        $this->requestStack->getSession()->getFlashBag()
            ->add('info', $this->translator->trans('sherlockode_sylius_acb.form.version_edit', [
                '%version%' => $version->getId(),
                '%date%' => $formatter->format($version->getCreatedAt()),
            ]))
        ;
    }
}
