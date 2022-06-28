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

namespace App\Modifier;

use App\Entity\Animal\Pet;
use App\Entity\Booking\Booking;
use App\Entity\Customer\CustomerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Sylius\Component\Customer\Context\CustomerContextInterface;

final class PetModifier implements PetModifierInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private CustomerContextInterface $customerContext,
    ) {
    }

    public function createBooking(Pet $pet): void
    {
        /** @var CustomerInterface $booker */
        $booker = $this->customerContext->getCustomer();
        $booking = Booking::createForPetAndBooker($pet, $booker);

        $this->entityManager->persist($booking);
        $this->entityManager->flush();
    }

    public function enablePet(Pet $pet): void
    {
        $pet->setEnabled(true);
    }

    public function disablePet(Pet $pet): void
    {
        $pet->setEnabled(false);
    }
}
