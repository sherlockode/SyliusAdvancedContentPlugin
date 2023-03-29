<?php

namespace Sherlockode\SyliusAdvancedContentPlugin\Factory;

use Doctrine\ORM\EntityManagerInterface;
use Sherlockode\AdvancedContentBundle\Manager\ConfigurationManager;
use Sherlockode\AdvancedContentBundle\Manager\ContentManager;
use Sherlockode\AdvancedContentBundle\Model\ContentInterface;
use Sylius\Bundle\ResourceBundle\Controller\NewResourceFactoryInterface;
use Sylius\Bundle\ResourceBundle\Controller\RequestConfiguration;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Resource\Model\ResourceInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NewContentFactory implements NewResourceFactoryInterface
{
    /**
     * @var NewResourceFactoryInterface
     */
    private $newResourceFactory;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var ConfigurationManager
     */
    private $configurationManager;

    /**
     * @var ContentManager
     */
    private $contentManager;

    /**
     * @param NewResourceFactoryInterface $newResourceFactory
     * @param EntityManagerInterface      $em
     * @param ConfigurationManager        $configurationManager
     * @param ContentManager              $contentManager
     */
    public function __construct(
        NewResourceFactoryInterface $newResourceFactory,
        EntityManagerInterface $em,
        ConfigurationManager $configurationManager,
        ContentManager $contentManager
    ) {
        $this->newResourceFactory = $newResourceFactory;
        $this->em = $em;
        $this->configurationManager = $configurationManager;
        $this->contentManager = $contentManager;
    }

    public function create(RequestConfiguration $requestConfiguration, FactoryInterface $factory): ResourceInterface
    {
        $resource = $this->newResourceFactory->create($requestConfiguration, $factory);

        if (!$resource instanceof ContentInterface) {
            return $resource;
        }

        $request = $requestConfiguration->getRequest();
        $duplicateId = $request->get('duplicateId');

        if ($duplicateId === null) {
            return $resource;
        }

        $content = $this->em->getRepository($this->configurationManager->getEntityClass('content'))->find($duplicateId);
        if ($content === null) {
            throw new NotFoundHttpException(sprintf('The content has not been found'));
        }

        return $this->contentManager->duplicate($content);
    }
}
