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
}
