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

use App\Colors;
use App\Entity\Animal\Pet;
use App\Fixture\Factory\PetExampleFactory;
use App\PetStates;
use App\Sex;
use App\SizeRanges;
use Behat\Behat\Context\Context;
use Doctrine\ORM\EntityManagerInterface;
use Monofony\Bridge\Behat\Service\SharedStorageInterface;
use Sylius\Component\Taxonomy\Model\TaxonInterface;
use Webmozart\Assert\Assert;

class PetContext implements Context
{
    /** @var SharedStorageInterface */
    private $sharedStorage;

    /** @var PetExampleFactory */
    private $animalFactory;

    /** @var EntityManagerInterface*/
    private $manager;

    public function __construct(
        SharedStorageInterface $sharedStorage,
        PetExampleFactory $animalFactory,
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
        $this->createWithOptions(['name' => $name, 'enabled' => true]);
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
     * @Given /^(it|this pet) is a male$/
     */
    public function thisPetIsAMale(Pet $animal)
    {
        $animal->setSex(Sex::MALE);
        $this->manager->flush();
    }

    /**
     * @Given /^(it|this pet) is a new pet$/
     */
    public function thisPetIsANewPet(Pet $animal)
    {
        $animal->setStatus(PetStates::NEW);
        $this->manager->flush();
    }

    /**
     * @Given /^(it|this pet) is bookable$/
     */
    public function thisPetIsBookable(Pet $animal)
    {
        $animal->setStatus(PetStates::BOOKABLE);
        $this->manager->flush();
    }

    /**
     * @Given /^(it|this pet) should be booked/
     */
    public function thisPetShouldBeBooked(Pet $animal)
    {
        Assert::eq($animal->getStatus(), 'booked');
    }

    /**
     * @Given /^(it|this pet) is a female$/
     */
    public function thisPetIsAFemale(Pet $animal)
    {
        $animal->setSex(Sex::FEMALE);
        $this->manager->flush();
    }

    /**
     * @Given /^(it|this pet) is small$/
     */
    public function thisPetIsSmall(Pet $animal)
    {
        $animal->setSizeRange(SizeRanges::SMALL);
        $this->manager->flush();
    }

    /**
     * @Given /^(it|this pet) is medium$/
     */
    public function thisPetIsMedium(Pet $animal)
    {
        $animal->setSizeRange(SizeRanges::MEDIUM);
        $this->manager->flush();
    }

    /**
     * @Given /^(it|this pet) is tall$/
     */
    public function thisPetIsTall(Pet $animal)
    {
        $animal->setSizeRange(SizeRanges::TALL);
        $this->manager->flush();
    }

    /**
     * @Given /^(it|this pet) is black$/
     */
    public function thisPetIsBlack(Pet $animal)
    {
        $animal->setMainColor(Colors::BLACK);
        $this->manager->flush();
    }

    /**
     * @Given /^(it|this pet) is white$/
     */
    public function thisPetIsWhite(Pet $animal)
    {
        $animal->setMainColor(Colors::WHITE);
        $this->manager->flush();
    }

    /**
     * @Given there are :numbersOfPets pets
     */
    public function thereArePets(int $numbersOfPets): void
    {
        for ($i = 0; $i < $numbersOfPets; ++$i) {
            $this->createWithOptions([]);
        }
    }

    private function createWithOptions(array $options): void
    {
        $pet = $this->animalFactory->create($options);
        $this->manager->persist($pet);
        $this->manager->flush();
        $this->sharedStorage->set('pet', $pet);
    }
}
