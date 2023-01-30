<?php

namespace Sherlockode\SyliusAdvancedContentPlugin\Entity;

use Sherlockode\AdvancedContentBundle\Model\FieldValue as BaseFieldValue;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="acb_field_value")
 */
class FieldValue extends BaseFieldValue
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
     * @var Content
     *
     * @ORM\ManyToOne(targetEntity="Sherlockode\SyliusAdvancedContentPlugin\Entity\Content", inversedBy="fieldValues")
     * @ORM\JoinColumn(name="content_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $content;
}
