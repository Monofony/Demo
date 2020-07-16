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

use ApiPlatform\Core\DataProvider\PaginatorInterface;
use Doctrine\ORM\QueryBuilder;
use Sylius\Component\Taxonomy\Model\TaxonInterface;

interface PetRepositoryInterface
{
    public function countAnimals(): int;

    public function findLatest(int $count): array;

    public function createListQueryBuilder($taxonId = null, $locale): QueryBuilder;

    public function createListForFrontQueryBuilder(string $localeCode, TaxonInterface $taxon = null): QueryBuilder;

    public function createListForApiPaginator(string $localeCode, int $page, array $filters = []): PaginatorInterface;
}
