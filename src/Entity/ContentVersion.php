<?php

namespace Sherlockode\SyliusAdvancedContentPlugin\Entity;

use Sherlockode\AdvancedContentBundle\Model\ContentVersion as BaseContentVersion;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="acb_content_version")
 */
class ContentVersion extends BaseContentVersion
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
     * @ORM\ManyToOne(targetEntity="Sherlockode\SyliusAdvancedContentPlugin\Entity\Content", inversedBy="versions")
     * @ORM\JoinColumn(name="content_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $content;
}
