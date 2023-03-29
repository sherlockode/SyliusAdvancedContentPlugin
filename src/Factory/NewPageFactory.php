<?php

namespace Sherlockode\SyliusAdvancedContentPlugin\Factory;

use Doctrine\ORM\EntityManagerInterface;
use Sherlockode\AdvancedContentBundle\Manager\ConfigurationManager;
use Sherlockode\AdvancedContentBundle\Manager\PageManager;
use Sherlockode\AdvancedContentBundle\Model\PageInterface;
use Sylius\Bundle\ResourceBundle\Controller\NewResourceFactoryInterface;
use Sylius\Bundle\ResourceBundle\Controller\RequestConfiguration;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Resource\Model\ResourceInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NewPageFactory implements NewResourceFactoryInterface
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
     * @var PageManager
     */
    private $pageManager;

    /**
     * @param NewResourceFactoryInterface $newResourceFactory
     * @param EntityManagerInterface      $em
     * @param ConfigurationManager        $configurationManager
     * @param PageManager                 $pageManager
     */
    public function __construct(
        NewResourceFactoryInterface $newResourceFactory,
        EntityManagerInterface $em,
        ConfigurationManager $configurationManager,
        PageManager $pageManager
    ) {
        $this->newResourceFactory = $newResourceFactory;
        $this->em = $em;
        $this->configurationManager = $configurationManager;
        $this->pageManager = $pageManager;
    }

    public function create(RequestConfiguration $requestConfiguration, FactoryInterface $factory): ResourceInterface
    {
        $resource = $this->newResourceFactory->create($requestConfiguration, $factory);

        if (!$resource instanceof PageInterface) {
            return $resource;
        }

        $request = $requestConfiguration->getRequest();
        $duplicateId = $request->get('duplicateId');

        if ($duplicateId === null) {
            return $resource;
        }

        $page = $this->em->getRepository($this->configurationManager->getEntityClass('page'))->find($duplicateId);
        if ($page === null) {
            throw new NotFoundHttpException(sprintf('The page has not been found'));
        }

        return $this->pageManager->duplicate($page);
    }
}
