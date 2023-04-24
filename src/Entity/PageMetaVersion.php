<?php

namespace Sherlockode\SyliusAdvancedContentPlugin\Entity;

use Sherlockode\AdvancedContentBundle\Model\PageMetaVersion as BasePageMetaVersion;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="acb_page_meta_version")
 */
class PageMetaVersion extends BasePageMetaVersion
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Sherlockode\SyliusAdvancedContentPlugin\Entity\PageMeta", inversedBy="versions")
     * @ORM\JoinColumn(name="page_meta_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $pageMeta;
}
