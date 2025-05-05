<?php

namespace Sherlockode\SyliusAdvancedContentPlugin\Entity;

use Doctrine\Common\Collections\Collection;
use Sherlockode\AdvancedContentBundle\Model\PageMeta as BasePageMeta;
use Doctrine\ORM\Mapping as ORM;

class PageMeta extends BasePageMeta implements PageMetaInterface
{
    protected $id;

    protected $page;

    protected $versions;
}
