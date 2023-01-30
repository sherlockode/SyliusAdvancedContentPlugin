<?php

namespace Sherlockode\SyliusAdvancedContentPlugin\Repository;

use Doctrine\ORM\QueryBuilder;
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
}
