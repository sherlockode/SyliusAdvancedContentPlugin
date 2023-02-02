<?php

namespace Sherlockode\SyliusAdvancedContentPlugin\Menu;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

class AdminMenuListener
{
    /**
     * @param MenuBuilderEvent $event
     */
    public function addAdminMenuItems(MenuBuilderEvent $event): void
    {
        $menu = $event->getMenu();

        $contentSubmenu = $menu
            ->addChild('acb_content')
            ->setLabel('sherlockode_sylius_acb.ui.content_menu')
        ;

        $contentSubmenu
            ->addChild('acb_pages', ['route' => 'sherlockode_sylius_acb_admin_page_index'])
            ->setLabel('sherlockode_sylius_acb.ui.pages')
            ->setLabelAttribute('icon', 'sticky note')
        ;

        $contentSubmenu
            ->addChild('app_contents', ['route' => 'sherlockode_sylius_acb_admin_content_index'])
            ->setLabel('sherlockode_sylius_acb.ui.contents')
            ->setLabelAttribute('icon', 'sticky note outline')
        ;

        $contentSubmenu
            ->addChild('app_tools', ['route' => 'sherlockode_acb_tools_index'])
            ->setLabel('sherlockode_sylius_acb.ui.tools')
            ->setLabelAttribute('icon', 'cogs')
        ;
    }
}
