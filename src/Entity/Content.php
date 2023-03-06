<?php

namespace Sherlockode\SyliusAdvancedContentPlugin\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Sherlockode\AdvancedContentBundle\Model\Content as BaseContent;
use Sherlockode\AdvancedContentBundle\Model\ContentVersionInterface;
use Sylius\Component\Resource\Model\ResourceInterface;

/**
 * @ORM\Entity(repositoryClass="Sherlockode\SyliusAdvancedContentPlugin\Repository\ContentRepository")
 * @ORM\Table(name="acb_content")
 */
class Content extends BaseContent implements ResourceInterface
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
     * @ORM\ManyToOne(targetEntity="Sherlockode\SyliusAdvancedContentPlugin\Entity\Page", inversedBy="contents")
     * @ORM\JoinColumn(name="page_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $page;

    /**
     * @var ContentVersionInterface
     *
     * @ORM\OneToOne(targetEntity="Sherlockode\SyliusAdvancedContentPlugin\Entity\ContentVersion")
     * @ORM\JoinColumn(name="content_version_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $contentVersion;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="Sherlockode\SyliusAdvancedContentPlugin\Entity\ContentVersion", mappedBy="content", cascade={"persist", "remove"})
     * @ORM\OrderBy({"createdAt": "DESC"})
     */
    protected $versions;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="Sherlockode\SyliusAdvancedContentPlugin\Entity\Scope")
     * @ORM\JoinTable(name="acb_content_scope",
     *      joinColumns={@ORM\JoinColumn(name="content_id", referencedColumnName="id", onDelete="cascade")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="scope_id", referencedColumnName="id", onDelete="cascade")}
     * )
     */
    protected $scopes;
}
