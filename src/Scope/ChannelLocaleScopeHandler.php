<?php

namespace Sherlockode\SyliusAdvancedContentPlugin\Scope;

use Sherlockode\AdvancedContentBundle\Scope\ScopeHandler;

class ChannelLocaleScopeHandler extends ScopeHandler
{
    /**
     * @return string|null
     */
    public function getScopeGroupBy(): ?string
    {
        return 'channel.name';
    }
}
