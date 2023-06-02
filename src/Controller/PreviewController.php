<?php

namespace Sherlockode\SyliusAdvancedContentPlugin\Controller;

use Sherlockode\AdvancedContentBundle\Scope\ScopeHandlerInterface;
use Sherlockode\SyliusAdvancedContentPlugin\Preview\ViewHandlerInterface;
use Sherlockode\SyliusAdvancedContentPlugin\Scope\ChannelLocaleScopeHandler;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PreviewController extends AbstractController
{
    /**
     * @var ChannelLocaleScopeHandler
     */
    private $channelLocaleScopeHandler;

    /**
     * @var RepositoryInterface
     */
    private $pageRepository;

    /**
     * @var ViewHandlerInterface
     */
    private $viewHandler;

    /**
     * @param ScopeHandlerInterface $channelLocaleScopeHandler
     * @param RepositoryInterface   $pageRepository
     * @param ViewHandlerInterface  $viewHandler
     */
    public function __construct(
        ScopeHandlerInterface $channelLocaleScopeHandler,
        RepositoryInterface $pageRepository,
        ViewHandlerInterface $viewHandler
    ) {
        $this->channelLocaleScopeHandler = $channelLocaleScopeHandler;
        $this->pageRepository = $pageRepository;
        $this->viewHandler = $viewHandler;
    }

    /**
     * @param Request $request
     * @param string  $pageIdentifier
     *
     * @return Response
     *
     * @throws \Exception
     */
    public function previewAction(
        Request $request,
        string $pageIdentifier
    ): Response {
        $channelCode = $request->query->get('_channel_code');
        $localeCode = $request->query->get('_locale');

        $scope = $this->channelLocaleScopeHandler->getScopeFromData([
            'channel' => $channelCode,
            'locale' => $localeCode,
        ]);

        if (!$scope) {
            throw new NotFoundHttpException(sprintf(
                'Scope for channel "%s" and locale "%s" does not exists',
                $channelCode,
                $localeCode
            ));
        }

        $page = $this->pageRepository->findOneByPageIdentifier($pageIdentifier, $scope);

        if (!$page) {
            throw new NotFoundHttpException(sprintf(
                'Page with scope for channel "%s" and locale "%s" does not exists',
                $channelCode,
                $localeCode
            ));
        }

        $template = $this->viewHandler->getViewTemplate($page, $scope);

        if (!$template) {
            throw new \Exception(sprintf(
                'Cannot find any template for the page "%s" preview',
                $page->getPageIdentifier()
            ));
        }

        return $this->render($template, ['page' => $page]);
    }
}
