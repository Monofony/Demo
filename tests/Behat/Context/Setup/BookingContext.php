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

use App\BookingStates;
use App\Entity\Animal\Pet;
use App\Entity\Booking\Booking;
use App\Fixture\Factory\BookingExampleFactory;
use Behat\Behat\Context\Context;
use Doctrine\ORM\EntityManagerInterface;
use Monofony\Bundle\CoreBundle\Tests\Behat\Service\SharedStorageInterface;
use Sylius\Component\Customer\Model\CustomerInterface;

final class BookingContext implements Context
{
    /** @var SharedStorageInterface */
    private $sharedStorage;

    /** @var BookingExampleFactory */
    private $bookingFactory;

    /** @var EntityManagerInterface*/
    protected $manager;

    public function __construct(
        SharedStorageInterface $sharedStorage,
        BookingExampleFactory $bookingFactory,
        EntityManagerInterface $manager
    ) {
        $this->sharedStorage = $sharedStorage;
        $this->bookingFactory = $bookingFactory;
        $this->manager = $manager;
    }

    /**
     * @Given /^(this pet) has been booked by (customer "([^"]+)")$/
     */
    public function thereIsABookingForTheAnimal(Pet $pet, CustomerInterface $customer)
    {
        $booking = $this->bookingFactory->create(['pet' => $pet, 'customer' => $customer, 'status' => BookingStates::NEW]);

        $this->manager->persist($booking);
        $this->manager->flush();
        $this->sharedStorage->set('booking', $booking);
    }

    /**
     * @Given /^(this booking) has been canceled$/
     */
    public function thisBookingHasBeenCanceled(Booking $booking)
    {
        $booking->setStatus(BookingStates::CANCELED);
    }

    /**
     * @Given there are :numbersOfBookings bookings
     */
    public function thereAreBookings(int $numbersOfBookings)
    {
        for ($i = 0; $i < $numbersOfBookings; ++$i) {
            $this->createWithOptions();
        }
    }

    private function createWithOptions(): void
    {
        $booking = $this->bookingFactory->create();
        $this->manager->persist($booking);
        $this->manager->flush();
        $this->sharedStorage->set('booking', $booking);
    }
}
