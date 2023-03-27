<?php

namespace Sherlockode\SyliusAdvancedContentPlugin\Scope;

use Sherlockode\AdvancedContentBundle\Scope\ScopeHandlerInterface;

class ChannelLocaleScopeHandler implements ScopeHandlerInterface
{
    /**
     * @return string|null
     */
    public function getScopeGroupBy(): ?string
    {
        return 'channel.name';
    }
}
