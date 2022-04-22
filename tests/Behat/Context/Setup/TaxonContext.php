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

namespace App\Tests\Behat\Context\Setup;

use App\Entity\Taxonomy\Taxon;
use App\Factory\TaxonFactory;
use Behat\Behat\Context\Context;
use Doctrine\ORM\EntityManagerInterface;
use Monofony\Bridge\Behat\Service\SharedStorageInterface;
use Sylius\Component\Taxonomy\Model\TaxonInterface;

final class TaxonContext implements Context
{
    public function __construct(
        private SharedStorageInterface $sharedStorage,
        private EntityManagerInterface $entityManager,
    ) {
    }

    /**
     * @Given there is (also) a taxon with name :name
     */
    public function thereIsATaxonWithName(string $name): void
    {
        $this->createWithOptions(['name' => $name]);
    }

    /**
     * @Given pets are classified under :firstTaxonName and :secondTaxonName categories
     */
    public function petsAreClassifiedUnderAndCategories(...$taxonNames): void
    {
        foreach ($taxonNames as $taxonName) {
            $this->createWithOptions(['name' => $taxonName]);
        }
    }

    /**
     * @Given /^the ("[^"]+" category) has children category "([^"]+)" and "([^"]+)"$/
     */
    public function theTaxonHasChildrenTaxonAnd(TaxonInterface $taxon, $firstTaxonName, $secondTaxonName)
    {
        $this->createWithOptions(['name' => $firstTaxonName, 'parent' => $taxon]);
        $this->createWithOptions(['name' => $secondTaxonName, 'parent' => $taxon]);
    }

    private function createWithOptions(array $options): void
    {
        $taxon = TaxonFactory::createOne($options);
        $taxon = $this->entityManager->getRepository(Taxon::class)->find($taxon->getId());

        $this->sharedStorage->set('taxon', $taxon);
    }
}
