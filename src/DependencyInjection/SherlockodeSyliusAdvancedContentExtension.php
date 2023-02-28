<?php

namespace Sherlockode\SyliusAdvancedContentPlugin\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;

/**
 * Class SherlockodeSyliusAdvancedContentExtension
 */
class SherlockodeSyliusAdvancedContentExtension extends Extension implements PrependExtensionInterface
{
    public function load(array $configs, ContainerBuilder $container)
    {

    }

    public function prepend(ContainerBuilder $container)
    {
        $this->prependDefaultEntities($container);
        $this->prependTwigPaths($container);
    }

    protected function prependTwigPaths(ContainerBuilder $container)
    {
        if (!$container->hasExtension('twig')) {
            return;
        }

        $acbResourceDir = __DIR__ . '/../Resources/views/AdvancedContentBundle';
        $container->prependExtensionConfig('twig', [
            'paths' => [
                $acbResourceDir => 'SherlockodeAdvancedContent',
            ],
        ]);
    }

    /**
     * Setup the Plugin entities as default for sherlockode_advanced_content
     *
     * @param ContainerBuilder $container
     *
     * @return void
     */
    protected function prependDefaultEntities(ContainerBuilder $container)
    {
        $container->prependExtensionConfig('sherlockode_advanced_content', [
            'entity_class' => [
                'content' => 'Sherlockode\SyliusAdvancedContentPlugin\Entity\Content',
                'content_version' => 'Sherlockode\SyliusAdvancedContentPlugin\Entity\ContentVersion',
                'page_type' => 'Sherlockode\SyliusAdvancedContentPlugin\Entity\PageType',
                'page' => 'Sherlockode\SyliusAdvancedContentPlugin\Entity\Page',
                'page_meta' => 'Sherlockode\SyliusAdvancedContentPlugin\Entity\PageMeta',
            ],
            'templates' => [
                'tools' => '@SherlockodeSyliusAdvancedContentPlugin/tools.html.twig',
            ],
        ]);
    }
}
