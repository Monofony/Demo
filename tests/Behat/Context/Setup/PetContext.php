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

use App\Entity\Animal\Pet;
use App\Fixture\Factory\AnimalExampleFactory;
use Behat\Behat\Context\Context;
use Doctrine\ORM\EntityManagerInterface;
use Monofony\Bundle\CoreBundle\Tests\Behat\Service\SharedStorageInterface;
use Sylius\Component\Taxonomy\Model\TaxonInterface;

class PetContext implements Context
{
    /** @var SharedStorageInterface */
    private $sharedStorage;

    /** @var AnimalExampleFactory */
    private $animalFactory;

    /** @var EntityManagerInterface*/
    private $manager;

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
     * @Given there is (also )a pet with name :name
     */
    public function thereIsAPetWithName(string $name): void
    {
        $animal = $this->animalFactory->create(['name' => $name]);

        $this->manager->persist($animal);
        $this->manager->flush();
        $this->sharedStorage->set('animal', $animal);
    }

    /**
     * @Given /^(it|this pet) (belongs to "[^"]+")$/
     */
    public function thisAnimalBelongsTo(Pet $animal, TaxonInterface $taxon)
    {
        $animal->setTaxon($taxon);
        $this->manager->flush();
    }

    /**
     * @Given there are :numbersOfPets animals
     */
    public function thereArePets(int $numbersOfPets): void
    {
        for ($i = 0; $i < $numbersOfPets; ++$i) {
            $this->createWithOptions();
        }
    }

    private function createWithOptions(): void
    {
        $pet = $this->animalFactory->create();
        $this->manager->persist($pet);
        $this->manager->flush();
        $this->sharedStorage->set('pet', $pet);
    }
}
