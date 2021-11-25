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
use Sylius\Component\Taxonomy\Model\TaxonInterface;

final class PetRepository extends EntityRepository
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

    public function createListQueryBuilder(?string $taxonId, string $locale): QueryBuilder
    {
        $queryBuilder = $this->createQueryBuilder('o');
        $queryBuilder
            ->innerJoin('o.taxon', 'animalTaxon')
            ->innerJoin('animalTaxon.translations', 'translation')
            ->andWhere('translation.locale = :locale')
            ->setParameter('locale', $locale)
        ;
        if (null !== $taxonId) {
            $queryBuilder
                ->andWhere('animalTaxon.id = :taxonId')
                ->setParameter('taxonId', $taxonId)
            ;
        }

        return $queryBuilder;
    }

    public function createListForFrontQueryBuilder(string $localeCode, TaxonInterface $taxon = null): QueryBuilder
    {
        $queryBuilder = $this->createQueryBuilder('o');
        $queryBuilder
            ->innerJoin('o.taxon', 'taxon')
            ->andWhere('o.enabled = :enabled')
            ->setParameter('enabled', true);

        if (null !== $taxon) {
            $queryBuilder
                ->andWhere('taxon.left >= :taxonLeft')
                ->andWhere('taxon.right <= :taxonRight')
                ->andWhere('taxon.root = :taxonRoot')
                ->setParameter('taxonLeft', $taxon->getLeft())
                ->setParameter('taxonRight', $taxon->getRight())
                ->setParameter('taxonRoot', $taxon->getRoot());
        }

        return $queryBuilder;
    }
}
