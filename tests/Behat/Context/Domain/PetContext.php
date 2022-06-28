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

namespace App\Tests\Behat\Context\Domain;

use App\Entity\Animal\Pet;
use App\PetStates;
use Behat\Behat\Context\Context;
use Doctrine\ORM\EntityManagerInterface;
use Webmozart\Assert\Assert;

class PetContext implements Context
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    /**
     * @Given /^(this pet) is bookable$/
     */
    public function thisPetIsBookable(Pet $pet): void
    {
        $pet->setStatus(PetStates::BOOKABLE);

        $this->entityManager->flush();
    }

    /**
     * @Then the pet :pet has been booked
     */
    public function thePetHasBeenBooked(Pet $pet): void
    {
        $this->entityManager->refresh($pet);

        Assert::eq($pet->getStatus(), PetStates::BOOKED);
    }
}
