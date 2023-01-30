<?php

namespace Sherlockode\SyliusAdvancedContentPlugin\Entity;

use Sherlockode\AdvancedContentBundle\Model\PageMeta as BasePageMeta;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Sherlockode\SyliusAdvancedContentPlugin\Repository\PageMetaRepository")
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
     * @ORM\ManyToOne(targetEntity="Sherlockode\SyliusAdvancedContentPlugin\Entity\Page", inversedBy="pageMetas")
     * @ORM\JoinColumn(name="page_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $page;
}
