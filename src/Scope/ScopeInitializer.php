<?php

namespace Sherlockode\SyliusAdvancedContentPlugin\Scope;

use App\Entity\Channel\Channel;
use Doctrine\ORM\EntityManagerInterface;
use Sherlockode\AdvancedContentBundle\Manager\ConfigurationManager;
use Sherlockode\SyliusAdvancedContentPlugin\Entity\Scope;

class ScopeInitializer
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var ConfigurationManager
     */
    private $configurationManager;

    /**
     * @param EntityManagerInterface $em
     * @param ConfigurationManager   $configurationManager
     */
    public function __construct(EntityManagerInterface $em, ConfigurationManager $configurationManager)
    {
        $this->em = $em;
        $this->configurationManager = $configurationManager;
    }

    public function init(): void
    {
        $scopeClass = $this->configurationManager->getEntityClass('scope');
        $scopeRepository = $this->em->getRepository($scopeClass);

        $channels = $this->em->getRepository(Channel::class)->findAll();
        /** @var Channel $channel */
        foreach ($channels as $channel) {
            foreach ($channel->getLocales() as $locale) {
                $scope = $scopeRepository->findOneBy([
                    'channel' => $channel,
                    'locale' => $locale,
                ]);
                if ($scope !== null) {
                    continue;
                }

                /** @var Scope $scope */
                $scope = new $scopeClass;
                $scope->setChannel($channel);
                $scope->setLocale($locale);
                $this->em->persist($scope);
            }
        }

        $this->em->flush();
    }

    /**
     * @return bool
     */
    public function hasMissingScopes(): bool
    {
        $scopes = $this->em->getRepository($this->configurationManager->getEntityClass('scope'))->findAll();

        $nbChannelLocales = 0;
        $channels = $this->em->getRepository(Channel::class)->findAll();
        /** @var Channel $channel */
        foreach ($channels as $channel) {
            $nbChannelLocales += $channel->getLocales()->count();
        }

        return count($scopes) !== $nbChannelLocales;
    }
}
