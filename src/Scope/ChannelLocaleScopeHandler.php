<?php

namespace Sherlockode\SyliusAdvancedContentPlugin\Scope;

use App\Entity\Channel\Channel;
use App\Entity\Locale\Locale;
use Sherlockode\AdvancedContentBundle\Model\ScopeInterface;
use Sherlockode\AdvancedContentBundle\Scope\ScopeHandler;
use Sherlockode\SyliusAdvancedContentPlugin\Entity\Scope;

class ChannelLocaleScopeHandler extends ScopeHandler
{
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
}
