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

namespace App\Modifier;

use App\Entity\Animal\Pet;
use App\Factory\BookingFactory;
use Doctrine\ORM\EntityManagerInterface;

final class PetModifier
{
    /** @var BookingFactory */
    private $bookingFactory;

    /** @var EntityManagerInterface */
    private $manager;

    public function __construct(BookingFactory $bookingFactory, EntityManagerInterface $manager)
    {
        $this->bookingFactory = $bookingFactory;
        $this->manager = $manager;
    }

    public function createBooking(Pet $pet): void
    {
        $this->manager->persist($this->bookingFactory->createForPet($pet));
        $this->manager->flush();
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
