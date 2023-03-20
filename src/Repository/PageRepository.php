<?php

namespace Sherlockode\SyliusAdvancedContentPlugin\Repository;

use App\Entity\Channel\Channel;
use App\Entity\Locale\Locale;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\QueryBuilder;
use Sherlockode\AdvancedContentBundle\Model\PageInterface;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Sylius\Component\Resource\Repository\RepositoryInterface;

class PageRepository extends EntityRepository
{
    /**
     * @param string  $identifier
     * @param Channel $channel
     * @param Locale  $locale
     *
     * @return PageInterface|null
     *
     * @throws NonUniqueResultException
     */
    public function findOneByPageIdentifierAndScope(string $identifier, Channel $channel, Locale $locale): ?PageInterface
    {
        return $this->getByScopeQueryBuilder($channel, $locale)
            ->andWhere('page.pageIdentifier = :pageIdentifier')
            ->setParameter('pageIdentifier', $identifier)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param string  $slug
     * @param Channel $channel
     * @param Locale  $locale
     *
     * @return PageInterface|null
     *
     * @throws NonUniqueResultException
     */
    public function findOneBySlugAndScope(string $slug, Channel $channel, Locale $locale): ?PageInterface
    {
        return $this->getByScopeQueryBuilder($channel, $locale)
            ->join('page.pageMeta', 'page_meta')
            ->andWhere('page_meta.slug = :slug')
            ->setParameter('slug', $slug)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param Channel $channel
     * @param Locale  $locale
     *
     * @return QueryBuilder
     */
    private function getByScopeQueryBuilder(Channel $channel, Locale $locale): QueryBuilder
    {
        return $this->createQueryBuilder('page')
            ->join('page.scopes', 'scope')
            ->andWhere('scope.channel = :channel')
            ->andWhere('scope.locale = :locale')
            ->setParameters([
                'channel' => $channel,
                'locale' => $locale,
            ]);
    }
}
