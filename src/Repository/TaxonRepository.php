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

use Sylius\Bundle\TaxonomyBundle\Doctrine\ORM\TaxonRepository as BaseTaxonRepository;

final class TaxonRepository extends BaseTaxonRepository
{
    public function findTaxonsWithoutChildren(): array
    {
        $queryBuilder = $this->createQueryBuilder('o');
        $queryBuilder
            ->leftJoin('o.children', 'child')
            ->andWhere($queryBuilder->expr()->isNull('child.id'));

        return $queryBuilder->getQuery()->getResult();
    }
}
