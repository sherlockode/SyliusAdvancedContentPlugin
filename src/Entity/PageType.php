<?php

namespace Sherlockode\SyliusAdvancedContentPlugin\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sherlockode\AdvancedContentBundle\Model\PageType as BasePageType;

class PageType extends BasePageType implements PageTypeInterface
{
    protected $id;
}
