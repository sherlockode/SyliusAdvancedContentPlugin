<?php

namespace Sherlockode\SyliusAdvancedContentPlugin\EventListener;

use Doctrine\ORM\Event\OnFlushEventArgs;
use Sherlockode\AdvancedContentBundle\Manager\ConfigurationManager;
use Sylius\Component\Core\Model\ChannelInterface;

class ChannelListener
{
    /**
     * @var ConfigurationManager
     */
    private $configurationManager;

    /**
     * @param ConfigurationManager $configurationManager
     */
    public function __construct(ConfigurationManager $configurationManager)
    {
        $this->configurationManager = $configurationManager;
    }

    /**
     * @param OnFlushEventArgs $args
     */
    public function onFlush(OnFlushEventArgs $args)
    {
        $em = $args->getEntityManager();
        $uow = $em->getUnitOfWork();

        $entities = [
            ...$uow->getScheduledEntityInsertions(),
            ...$uow->getScheduledEntityUpdates()
        ];

        $scopeClass = $this->configurationManager->getEntityClass('scope');
        $scopeClassMetadata = $em->getClassMetadata($scopeClass);
        $scopeRepository = $em->getRepository($scopeClass);
        foreach ($entities as $entity) {
            if (!$entity instanceof ChannelInterface) {
                continue;
            }

            $existingScopes = $scopeRepository->findBy([
                'channel' => $entity,
            ]);

            foreach ($entity->getLocales() as $locale) {
                foreach ($existingScopes as $key => $existingScope) {
                    if ($locale->getId() === $existingScope->getLocale()->getId()) {
                        unset($existingScopes[$key]);
                        continue 2;
                    }
                }

                $scope = new $scopeClass;
                $scope->setChannel($entity);
                $scope->setLocale($locale);
                $em->persist($scope);
                $uow->computeChangeSet($scopeClassMetadata, $scope);
            }

            foreach ($existingScopes as $existingScope) {
                $em->remove($existingScope);
                $uow->computeChangeSet($scopeClassMetadata, $existingScope);
            }
        }
    }
}
