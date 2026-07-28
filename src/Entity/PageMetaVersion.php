<?php

declare(strict_types=1);

namespace Sherlockode\SyliusAdvancedContentPlugin\Entity;

use Sherlockode\AdvancedContentBundle\Model\PageMetaVersion as BasePageMetaVersion;
use Doctrine\ORM\Mapping as ORM;

class PageMetaVersion extends BasePageMetaVersion implements PageMetaVersionInterface
{
    protected $id;

    protected $pageMeta;
}
