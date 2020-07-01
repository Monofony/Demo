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

namespace App\Tests\Behat\Context\Setup;

use App\Entity\Taxonomy\Taxon;
use App\Fixture\Factory\TaxonExampleFactory;
use App\SizeRanges;
use Behat\Behat\Context\Context;
use Doctrine\ORM\EntityManagerInterface;
use Monofony\Bundle\CoreBundle\Tests\Behat\Service\SharedStorageInterface;
use Sylius\Component\Taxonomy\Model\TaxonInterface;

final class TaxonContext implements Context
{
    /** @var SharedStorageInterface */
    private $sharedStorage;

    /** @var TaxonExampleFactory */
    private $taxonFactory;

    /** @var EntityManagerInterface*/
    protected $manager;


    public function __construct(
        SharedStorageInterface $sharedStorage,
        TaxonExampleFactory $taxonFactory,
        EntityManagerInterface $manager
    ) {
        $this->sharedStorage = $sharedStorage;
        $this->taxonFactory = $taxonFactory;
        $this->manager = $manager;
    }

    /**
     * @Given there is (also )a taxon with name :name
     */
    public function thereIsATaxonWithName(string $name): void
    {
        $taxon = $this->createWithOptions(['name' => $name]);

        $this->manager->persist($taxon);
        $this->manager->flush();
    }

    /**
     * @Given /^(it|this taxon) contains small pets/
     */
    public function thisTaxonIsSmall(Taxon $taxon)
    {
        $taxon->setSizeRange(SizeRanges::SMALL);
        $this->manager->flush();
    }

    /**
     * @Given /^(it|this taxon) contains medium pets/
     */
    public function thisTaxonIsMedium(Taxon $taxon)
    {
        $taxon->setSizeRange(SizeRanges::MEDIUM);
        $this->manager->flush();
    }

    /**
     * @Given pets are classified under :firstTaxonName and :secondTaxonName categories
     */
    public function petsAreClassifiedUnderAndCategories(...$taxonNames)
    {
        foreach ($taxonNames as $taxonName) {
            $taxon = $this->createWithOptions(['name' => $taxonName]);
            $this->manager->persist($taxon);
        }

        $this->manager->flush();
    }

    /**
     * @Given /^the ("[^"]+" category) has children category "([^"]+)" and "([^"]+)"$/
     */
    public function theTaxonHasChildrenTaxonAnd(TaxonInterface $taxon, $firstTaxonName, $secondTaxonName)
    {
        $firstTaxon = $this->createWithOptions(['name' => $firstTaxonName, 'parent' => $taxon]);
        $secondTaxon = $this->createWithOptions(['name' => $secondTaxonName, 'parent' => $taxon]);

        $this->manager->persist($firstTaxon);
        $this->manager->persist($secondTaxon);
        $this->manager->flush();
    }

    private function createWithOptions(array $options): TaxonInterface
    {
        $taxon = $this->taxonFactory->create($options);
        $this->sharedStorage->set('taxon', $taxon);

        return $taxon;
    }
}
