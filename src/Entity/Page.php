<?php

namespace Sherlockode\SyliusAdvancedContentPlugin\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Sherlockode\AdvancedContentBundle\Model\Page as BasePage;
use Sylius\Component\Resource\Model\ResourceInterface;

/**
 * @ORM\Entity(repositoryClass="Sherlockode\SyliusAdvancedContentPlugin\Repository\PageRepository")
 * @ORM\Table(name="acb_page")
 */
class Page extends BasePage implements ResourceInterface
{
    use TimestampableEntity;
    use BlameableEntity;

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="Sherlockode\SyliusAdvancedContentPlugin\Entity\Content", mappedBy="page", cascade={"persist", "remove"})
     */
    protected $content;

    /**
     * @ORM\ManyToOne(targetEntity="Sherlockode\SyliusAdvancedContentPlugin\Entity\PageType")
     * @ORM\JoinColumn(name="page_type_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $pageType;

    /**
     * @ORM\OneToOne(targetEntity="Sherlockode\SyliusAdvancedContentPlugin\Entity\PageMeta", mappedBy="page", cascade={"persist", "remove"})
     */
    protected $pageMeta;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="Sherlockode\SyliusAdvancedContentPlugin\Entity\Scope")
     * @ORM\JoinTable(name="acb_page_scope",
     *      joinColumns={@ORM\JoinColumn(name="page_id", referencedColumnName="id", onDelete="cascade")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="scope_id", referencedColumnName="id", onDelete="cascade")}
     * )
     */
    protected $scopes;
}
