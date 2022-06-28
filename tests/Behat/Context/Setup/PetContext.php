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

use App\Colors;
use App\Entity\Animal\Pet;
use App\Entity\Taxonomy\Taxon;
use App\Factory\PetFactory;
use App\PetStates;
use App\Sexes;
use App\SizeRanges;
use Behat\Behat\Context\Context;
use Doctrine\ORM\EntityManagerInterface;
use Monofony\Bridge\Behat\Service\SharedStorageInterface;
use Sylius\Component\Taxonomy\Model\TaxonInterface;

final class PetContext implements Context
{
    public function __construct(
        private SharedStorageInterface $sharedStorage,
        private EntityManagerInterface $entityManager,
    ) {
    }

    /**
     * @Given there is (also) a pet with name :name
     */
    public function thereIsAPetWithName(string $name): void
    {
        $this->createWithOptions(['name' => $name, 'status' => PetStates::BOOKABLE]);
    }

    /**
     * @Given there are :numbersOfPets pets
     */
    public function thereArePets(int $numbersOfPets): void
    {
        for ($i = 0; $i < $numbersOfPets; ++$i) {
            $this->createWithOptions(['status' => PetStates::BOOKABLE]);
        }
    }

    /**
     * @Given /^(it|this pet) (belongs to "[^"]+")$/
     */
    public function thisPetBelongsTo(Pet $pet, TaxonInterface $taxon): void
    {
        $pet->setTaxon($taxon);

        $this->entityManager->flush();
    }

    /**
     * @Given /^(it|this pet) is black$/
     */
    public function thisPetIsBlack(Pet $pet): void
    {
        $pet->setMainColor(Colors::BLACK);

        $this->entityManager->flush();
    }

    /**
     * @Given /^(it|this pet) is white$/
     */
    public function thisPetIsWhite(Pet $pet): void
    {
        $pet->setMainColor(Colors::WHITE);

        $this->entityManager->flush();
    }

    /**
     * @Given /^(it|this pet) is a male$/
     */
    public function thisPetIsAMale(Pet $animal): void
    {
        $animal->setSex(Sexes::MALE);

        $this->entityManager->flush();
    }

    /**
     * @Given /^(it|this pet) is a female$/
     */
    public function thisPetIsAFemale(Pet $animal): void
    {
        $animal->setSex(Sexes::FEMALE);

        $this->entityManager->flush();
    }

    /**
     * @Given /^(it|this taxon) contains small pets/
     */
    public function thisTaxonIsSmall(Taxon $taxon)
    {
        $taxon->setSizeRange(SizeRanges::SMALL);

        $this->entityManager->flush();
    }

    /**
     * @Given /^(it|this taxon) contains medium pets/
     */
    public function thisTaxonIsMedium(Taxon $taxon)
    {
        $taxon->setSizeRange(SizeRanges::MEDIUM);

        $this->entityManager->flush();
    }

    private function createWithOptions(array $options): void
    {
        $pet = PetFactory::createOne($options);
        $pet = $this->entityManager->getRepository(Pet::class)->find($pet->getId());

        $this->sharedStorage->set('pet', $pet);
    }
}
