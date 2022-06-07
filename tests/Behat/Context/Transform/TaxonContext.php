<?php

/*
 * This file is part of the Monofony demo project.
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
use Sylius\Component\Taxonomy\Repository\TaxonRepositoryInterface;
use Webmozart\Assert\Assert;

final class TaxonContext implements Context
{
    public function __construct(private TaxonRepositoryInterface $taxonRepository)
    {
    }

    /**
     * @Transform :taxon
     * @Transform /^taxon "([^"]+)"$/
     * @Transform /^"([^"]+)" category$/
     * @Transform /^belongs to "([^"]+)"$/
     */
    public function getTaxonByName(string $taxonName): Taxon
    {
        $taxa = $this->taxonRepository->findByName($taxonName, 'en_US');
        Assert::eq(
            count($taxa),
            1,
            sprintf('%d taxons has been found with name "%s".', count($taxa), $taxonName),
        );

        return $taxa[0];
    }
}
