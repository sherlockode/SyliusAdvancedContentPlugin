<?php

namespace Sherlockode\SyliusAdvancedContentPlugin\Entity;

use App\Entity\Channel\Channel;
use App\Entity\Locale\Locale;
use Doctrine\ORM\Mapping as ORM;

use Sherlockode\AdvancedContentBundle\Model\Scope as BaseScope;

/**
 * @ORM\Entity
 * @ORM\Table(name="acb_scope")
 */
class Scope extends BaseScope
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="integer")
     */
    protected $id;

    /**
     * @var Channel
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Channel\Channel")
     * @ORM\JoinColumn(name="channel_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $channel;

    /**
     * @var Locale
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Locale\Locale")
     * @ORM\JoinColumn(name="locale_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $locale;

    /**
     * @return string
     */
    public function getOptionTitle(): string
    {
        return $this->locale ? $this->locale->getCode() : '';
    }

    /**
     * @return Channel|null
     */
    public function getChannel(): ?Channel
    {
        return $this->channel;
    }

    /**
     * @param Channel $channel
     *
     * @return $this
     */
    public function setChannel(Channel $channel): self
    {
        $this->channel = $channel;

        return $this;
    }

    /**
     * @return Locale|null
     */
    public function getLocale(): ?Locale
    {
        return $this->locale;
    }

    /**
     * @param Locale $locale
     *
     * @return $this
     */
    public function setLocale(Locale $locale): self
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * @return string
     */
    public function getUnicityIdentifier()
    {
        $identifier = '';
        if ($this->channel !== null) {
            $identifier = $this->channel->getName();
        }
        if ($this->locale !== null) {
            if ($identifier !== '') {
                $identifier .= ' - ';
            }
            $identifier .= $this->locale->getCode();
        }

        return $identifier;
    }
}
