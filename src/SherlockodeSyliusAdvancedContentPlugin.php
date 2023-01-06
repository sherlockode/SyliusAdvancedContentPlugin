<?php

declare(strict_types=1);

namespace Sherlockode\SyliusAdvancedContentPlugin;

use Sherlockode\SyliusAdvancedContentPlugin\DependencyInjection\Compiler\SyliusClassMappingCompilerPass;
use Sylius\Bundle\CoreBundle\Application\SyliusPluginTrait;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class SherlockodeSyliusAdvancedContentPlugin extends Bundle
{
    use SyliusPluginTrait;

    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new SyliusClassMappingCompilerPass(), PassConfig::TYPE_BEFORE_OPTIMIZATION, 5);
    }
}
