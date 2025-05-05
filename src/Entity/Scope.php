<?php

namespace Sherlockode\SyliusAdvancedContentPlugin\Entity;

use App\Entity\Channel\Channel;
use App\Entity\Locale\Locale;
use Doctrine\ORM\Mapping as ORM;

use Sherlockode\AdvancedContentBundle\Model\Scope as BaseScope;

class Scope extends BaseScope implements ScopeInterface
{
    protected $id;

    protected $channel;

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
