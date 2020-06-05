<?php

/*
 * This file is part of the Monofony demo.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Repository;

use Doctrine\ORM\QueryBuilder;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

final class AnimalRepository extends EntityRepository
{
    public function countAnimals(): int
    {
        return (int) $this->createQueryBuilder('o')
            ->select('COUNT(o.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findLatest(int $count): array
    {
        return $this->createQueryBuilder('o')
            ->addOrderBy('o.id', 'DESC')
            ->setMaxResults($count)
            ->getQuery()
            ->getResult();
    }

    public function createListQueryBuilder($taxonId = null): QueryBuilder
    {
        $queryBuilder = $this->createQueryBuilder('o');

        if (null !== $taxonId) {
            $queryBuilder
                ->innerJoin('o.taxon', 'animalTaxon')
                ->andWhere('animalTaxon.id = :taxonId')
                ->setParameter('taxonId', $taxonId)
            ;
        }

        return $queryBuilder;
    }
}
