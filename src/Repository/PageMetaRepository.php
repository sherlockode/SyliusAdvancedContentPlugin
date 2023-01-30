<?php

namespace Sherlockode\SyliusAdvancedContentPlugin\Repository;

use Sherlockode\AdvancedContentBundle\Model\PageMetaInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\QueryBuilder;

class PageMetaRepository extends EntityRepository
{
    /**
     * @param string $identifier
     * @param string $locale
     *
     * @return PageMetaInterface|null
     *
     * @throws NonUniqueResultException
     */
    public function findOneByPageIdentifierAndLocale(string $identifier, string $locale): ?PageMetaInterface
    {
        return $this->getByLocaleQueryBuilder($locale)
            ->join('page_meta.page', 'page')
            ->andWhere('page.pageIdentifier = :pageIdentifier')
            ->setParameter('pageIdentifier', $identifier)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param string $slug
     * @param string $locale
     *
     * @return PageMetaInterface|null
     *
     * @throws NonUniqueResultException
     */
    public function findOneBySlugAndLocale(string $slug, string $locale): ?PageMetaInterface
    {
        return $this->getByLocaleQueryBuilder($locale)
            ->andWhere('page_meta.slug = :slug')
            ->setParameter('slug', $slug)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param string $locale
     *
     * @return QueryBuilder
     */
    private function getByLocaleQueryBuilder(string $locale): QueryBuilder
    {
        return $this->createQueryBuilder('page_meta')
            ->andWhere('page_meta.locale = :locale')
            ->setParameter('locale', $locale);
    }
}
