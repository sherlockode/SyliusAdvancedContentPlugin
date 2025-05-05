<?php

namespace Sherlockode\SyliusAdvancedContentPlugin\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Sherlockode\AdvancedContentBundle\Model\Page as BasePage;
use Sherlockode\AdvancedContentBundle\Model\PageVersionInterface;
use Sylius\Component\Resource\Model\ResourceInterface;

class Page extends BasePage implements PageInterface
{
    use TimestampableEntity;
    use BlameableEntity;

    protected $id;

    protected $content;

    protected $pageType;

    protected $pageMeta;

    protected $scopes;

    protected $pageVersion;

    protected $versions;
}
