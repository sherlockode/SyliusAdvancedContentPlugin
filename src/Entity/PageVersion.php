<?php

namespace Sherlockode\SyliusAdvancedContentPlugin\Entity;

use Sherlockode\AdvancedContentBundle\Model\PageVersion as BasePageVersion;
use Doctrine\ORM\Mapping as ORM;

class PageVersion extends BasePageVersion implements PageVersionInterface
{
    protected $id;

    protected $page;

    protected $contentVersion;

    protected $pageMetaVersion;
}
