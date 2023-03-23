<?php

namespace Sherlockode\SyliusAdvancedContentPlugin\Entity;

use Sherlockode\AdvancedContentBundle\Model\PageVersion as BasePageVersion;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="acb_page_version")
 */
class PageVersion extends BasePageVersion
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
     * @ORM\ManyToOne(targetEntity="Sherlockode\SyliusAdvancedContentPlugin\Entity\Page", inversedBy="versions")
     * @ORM\JoinColumn(name="page_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $page;

    /**
     * @ORM\OneToOne(targetEntity="Sherlockode\SyliusAdvancedContentPlugin\Entity\ContentVersion", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="content_version_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $contentVersion;

    /**
     * @ORM\OneToOne(targetEntity="Sherlockode\SyliusAdvancedContentPlugin\Entity\PageMetaVersion", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="page_meta_version_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $pageMetaVersion;
}
