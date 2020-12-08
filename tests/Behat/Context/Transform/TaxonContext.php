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

namespace App\Tests\Behat\Context\Transform;

use App\Entity\Taxonomy\Taxon;
use Behat\Behat\Context\Context;
use Doctrine\ORM\EntityManagerInterface;
use Sylius\Component\Taxonomy\Repository\TaxonRepositoryInterface;
use Webmozart\Assert\Assert;

final class TaxonContext implements Context
{
    /** @var TaxonRepositoryInterface */
    private $taxonRepository;

    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(
        TaxonRepositoryInterface $taxonRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->taxonRepository = $taxonRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Transform :taxon
     * @Transform /^taxon "([^"]+)"$/
     * @Transform /^"([^"]+)" category$/
     * @Transform /^belongs to "([^"]+)"$/
     */
    public function getTaxonByName(string $taxonName): Taxon
    {
        $taxons = $this->taxonRepository->findByName($taxonName, 'en_US');
        Assert::eq(
            count($taxons),
            1,
            sprintf('%d taxons has been found with name "%s".', count($taxons), $taxonName)
        );

        return $taxons[0];
    }
}
