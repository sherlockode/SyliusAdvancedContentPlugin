<?php

namespace Sherlockode\SyliusAdvancedContentPlugin\Repository;

use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\QueryBuilder;
use Sherlockode\AdvancedContentBundle\Model\ContentInterface;
use Sherlockode\AdvancedContentBundle\Model\ScopeInterface;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

class ContentRepository extends EntityRepository
{
    /**
     * @return QueryBuilder
     */
    public function createListQueryBuilder(): QueryBuilder
    {
        $queryBuilder = $this->createQueryBuilder('c')
            ->where('c.page IS NULL')
        ;

        return $queryBuilder;
    }

    /**
     * @param string              $slug
     * @param ScopeInterface|null $scope
     *
     * @return ContentInterface|null
     *
     * @throws NonUniqueResultException
     */
    public function findOneBySlug(string $slug, ?ScopeInterface $scope): ?ContentInterface
    {
        return $this->getByScopeQueryBuilder($scope)
            ->andWhere('content.slug = :slug')
            ->setParameter('slug', $slug)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param ScopeInterface|null $scope
     *
     * @return QueryBuilder
     */
    private function getByScopeQueryBuilder(?ScopeInterface $scope): QueryBuilder
    {
        $qb = $this->createQueryBuilder('content');
        if ($scope !== null) {
            $qb->join('content.scopes', 'scope')
                ->andWhere('scope.channel = :channel')
                ->andWhere('scope.locale = :locale')
                ->setParameters([
                    'channel' => $scope->getChannel(),
                    'locale'  => $scope->getLocale(),
                ]);
        }

        return $qb;
    }
}
