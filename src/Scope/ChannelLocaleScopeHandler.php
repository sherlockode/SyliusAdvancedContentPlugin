<?php

namespace Sherlockode\SyliusAdvancedContentPlugin\Scope;

use App\Entity\Channel\Channel;
use App\Entity\Locale\Locale;
use Doctrine\ORM\EntityManagerInterface;
use Sherlockode\AdvancedContentBundle\Manager\ConfigurationManager;
use Sherlockode\AdvancedContentBundle\Model\ScopableInterface;
use Sherlockode\AdvancedContentBundle\Model\ScopeInterface;
use Sherlockode\AdvancedContentBundle\Scope\ScopeHandler;
use Sherlockode\SyliusAdvancedContentPlugin\Entity\Scope;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;

class ChannelLocaleScopeHandler extends ScopeHandler
{
    /**
     * @var ChannelContextInterface
     */
    private $channelContext;

    /**
     * @var LocaleContextInterface
     */
    private $localeContext;

    /**
     * @param EntityManagerInterface  $em
     * @param ConfigurationManager    $configurationManager
     * @param ChannelContextInterface $channelContext
     * @param LocaleContextInterface  $localeContext
     */
    public function __construct(
        EntityManagerInterface $em,
        ConfigurationManager $configurationManager,
        ChannelContextInterface $channelContext,
        LocaleContextInterface $localeContext
    ) {
        parent::__construct($em, $configurationManager);

        $this->channelContext = $channelContext;
        $this->localeContext = $localeContext;
    }

    /**
     * @return string|null
     */
    public function getScopeGroupBy(): ?string
    {
        return 'channel.name';
    }

    /**
     * @param array $data
     *
     * @return ScopeInterface|null
     */
    public function getScopeFromData(array $data): ?ScopeInterface
    {
        if (empty($data['channel']) || empty($data['locale'])) {
            return null;
        }

        $channel = $this->em->getRepository(Channel::class)->findOneBy([
            'code' => $data['channel'],
        ]);
        $locale = $this->em->getRepository(Locale::class)->findOneBy([
            'code' => $data['locale'],
        ]);

        if ($channel === null || $locale === null) {
            return null;
        }

        return $this->em->getRepository($this->configurationManager->getEntityClass('scope'))->findOneBy([
            'channel' => $channel,
            'locale' => $locale,
        ]);
    }

    /**
     * @param ScopeInterface|Scope $scope
     *
     * @return array
     */
    public function getDataFromScope(ScopeInterface $scope): array
    {
        return [
            'channel' => $scope->getChannel()->getCode(),
            'locale' => $scope->getLocale()->getCode(),
        ];
    }

    /**
     * @return ScopeInterface|null
     */
    public function getCurrentScope(): ?ScopeInterface
    {
        if (!$this->configurationManager->isScopesEnabled()) {
            return null;
        }

        $channel = $this->channelContext->getChannel();
        $localeCode = $this->localeContext->getLocaleCode();
        $locale = $this->em->getRepository(Locale::class)->findOneBy([
            'code' => $localeCode,
        ]);

        if ($channel === null || $locale === null) {
            return null;
        }

        return $this->em->getRepository($this->configurationManager->getEntityClass('scope'))->findOneBy([
            'channel' => $channel,
            'locale' => $locale,
        ]);
    }
}
