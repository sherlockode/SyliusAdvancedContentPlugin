<?php

namespace Sherlockode\SyliusAdvancedContentPlugin\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Sherlockode\AdvancedContentBundle\Model\Content as BaseContent;
use Sherlockode\AdvancedContentBundle\Model\ContentVersionInterface;

class Content extends BaseContent implements ContentInterface
{
    protected $id;

    protected $page;

    protected $contentVersion;

    protected $versions;

    protected $scopes;
}
