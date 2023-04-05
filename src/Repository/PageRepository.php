<?php

namespace Sherlockode\SyliusAdvancedContentPlugin\Repository;

use App\Entity\Channel\Channel;
use App\Entity\Locale\Locale;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\QueryBuilder;
use Sherlockode\AdvancedContentBundle\Model\PageInterface;
use Sherlockode\AdvancedContentBundle\Model\ScopeInterface;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Sylius\Component\Resource\Repository\RepositoryInterface;

class PageRepository extends EntityRepository
{
    /**
     * @param string              $identifier
     * @param ScopeInterface|null $scope
     *
     * @return PageInterface|null
     *
     * @throws NonUniqueResultException
     */
    public function findOneByPageIdentifier(string $identifier, ?ScopeInterface $scope): ?PageInterface
    {
        return $this->getByScopeQueryBuilder($scope)
            ->andWhere('page.pageIdentifier = :pageIdentifier')
            ->setParameter('pageIdentifier', $identifier)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param string              $slug
     * @param ScopeInterface|null $scope
     *
     * @return PageInterface|null
     *
     * @throws NonUniqueResultException
     */
    public function findOneBySlug(string $slug, ?ScopeInterface $scope): ?PageInterface
    {
        return $this->getByScopeQueryBuilder($scope)
            ->join('page.pageVersion', 'page_version')
            ->join('page_version.pageMetaVersion', 'page_meta_version')
            ->andWhere('page_meta_version.slug = :slug')
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
        $qb = $this->createQueryBuilder('page');
        if ($scope !== null) {
            $qb->join('page.scopes', 'scope')
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
