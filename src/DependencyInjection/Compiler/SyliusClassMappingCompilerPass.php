<?php

namespace Sherlockode\SyliusAdvancedContentPlugin\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class SyliusClassMappingCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $mapping = $container->getParameter('sherlockode_advanced_content.entity_class_mapping');

        $grids = $container->getParameter('sylius.grids_definitions');
        $grids['sherlockode_sylius_acb_admin_page']['driver']['options']['class'] = $mapping['page'];
        $grids['sherlockode_sylius_acb_admin_content']['driver']['options']['class'] = $mapping['content'];
        $container->setParameter('sylius.grids_definitions', $grids);
    }
}
