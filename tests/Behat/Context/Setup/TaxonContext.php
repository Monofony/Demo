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

use App\Fixture\Factory\TaxonExampleFactory;
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
        $taxon->addChild($this->createWithOptions(['name' => $firstTaxonName]));
        $taxon->addChild($this->createWithOptions(['name' => $secondTaxonName]));

        $this->manager->persist($taxon);
        $this->manager->flush();
    }

    private function createWithOptions(array $options): TaxonInterface
    {
        $taxon = $this->taxonFactory->create($options);
        $this->sharedStorage->set('taxon', $taxon);

        return $taxon;
    }
}
