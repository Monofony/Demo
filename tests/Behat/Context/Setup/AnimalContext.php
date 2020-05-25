<?php

/*
 * This file is part of the Monofony demo.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests\Behat\Context\Setup;

use App\Entity\Animal\Animal;
use App\Fixture\Factory\AnimalExampleFactory;
use Behat\Behat\Context\Context;
use Doctrine\ORM\EntityManagerInterface;
use Monofony\Bundle\CoreBundle\Tests\Behat\Service\SharedStorageInterface;
use Sylius\Component\Taxonomy\Model\TaxonInterface;

class AnimalContext implements Context
{
    /** @var SharedStorageInterface */
    private $sharedStorage;

    /** @var AnimalExampleFactory */
    private $animalFactory;

    /** @var EntityManagerInterface*/
    protected $manager;


    public function __construct(
        SharedStorageInterface $sharedStorage,
        AnimalExampleFactory $animalFactory,
        EntityManagerInterface $manager
    ) {
        $this->sharedStorage = $sharedStorage;
        $this->animalFactory = $animalFactory;
        $this->manager = $manager;
    }

    /**
     * @Given there is (also )an animal with name :name
     */
    public function thereIsAnAnimalWithName(string $name): void
    {
        $animal = $this->animalFactory->create(['name' => $name]);

        $this->manager->persist($animal);
        $this->manager->flush();
        $this->sharedStorage->set('animal', $animal);
    }

    /**
     * @Given /^(it|this animal) (belongs to "[^"]+")$/
     */
    public function thisAnimalBelongsTo(Animal $animal, TaxonInterface $taxon)
    {
        $animal->setTaxon($taxon);
        $this->manager->flush();
    }
}
