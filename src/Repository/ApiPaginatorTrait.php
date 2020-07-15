<?php

/*
 * This file is part of the Monofony demo.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Repository;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Paginator;
use ApiPlatform\Core\DataProvider\PaginatorInterface;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;

trait ApiPaginatorTrait
{
    private static $itemsPerPage = 30;

    private function createApiPaginatorForPage(QueryBuilder $queryBuilder, int $page): PaginatorInterface
    {
        $firstResult = ($page - 1) * self::$itemsPerPage;

        $criteria = Criteria::create()
            ->setFirstResult($firstResult)
            ->setMaxResults(self::$itemsPerPage);
        $queryBuilder->addCriteria($criteria);

        $doctrinePaginator = new DoctrinePaginator($queryBuilder);

        return new Paginator($doctrinePaginator);
    }
}
