<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\Setup;

use App\Entity\Animal\Pet;
use App\Entity\Customer\CustomerInterface;
use App\Factory\BookingFactory;
use Behat\Behat\Context\Context;
use Monofony\Bridge\Behat\Service\SharedStorageInterface;

final class BookingContext implements Context
{
    public function __construct(private SharedStorageInterface $sharedStorage)
    {
    }

    /**
     * @Given /^(this pet) has been booked by (customer "([^"]+)")$/
     */
    public function thisPetHasBeenBookedByCustomer(Pet $pet, CustomerInterface $customer)
    {
        $this->createWithOptions(['pet' => $pet, 'booker' => $customer]);
    }

    private function createWithOptions(array $options): void
    {
        $booking = BookingFactory::createOne($options)->object();

        $this->sharedStorage->set('booking', $booking);
    }
}
