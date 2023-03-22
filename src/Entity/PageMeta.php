<?php

namespace Sherlockode\SyliusAdvancedContentPlugin\Entity;

use Doctrine\Common\Collections\Collection;
use Sherlockode\AdvancedContentBundle\Model\PageMeta as BasePageMeta;
use Doctrine\ORM\Mapping as ORM;
use Sherlockode\AdvancedContentBundle\Model\PageMetaVersionInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="acb_page_meta")
 */
class PageMeta extends BasePageMeta
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
     * @ORM\OneToOne(targetEntity="Sherlockode\SyliusAdvancedContentPlugin\Entity\Page", inversedBy="pageMeta")
     * @ORM\JoinColumn(name="page_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $page;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="Sherlockode\SyliusAdvancedContentPlugin\Entity\PageMetaVersion", mappedBy="pageMeta", cascade={"persist", "remove"})
     * @ORM\OrderBy({"createdAt": "DESC"})
     */
    protected $versions;
}
