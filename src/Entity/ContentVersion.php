<?php

namespace Sherlockode\SyliusAdvancedContentPlugin\Entity;

use Sherlockode\AdvancedContentBundle\Model\ContentVersion as BaseContentVersion;
use Doctrine\ORM\Mapping as ORM;

class ContentVersion extends BaseContentVersion implements ContentVersionInterface
{

    protected $id;

    protected $content;
}
