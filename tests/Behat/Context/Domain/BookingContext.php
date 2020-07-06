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

namespace App\Tests\Behat\Context\Domain;

use App\Entity\Animal\Pet;
use App\Repository\BookingRepository;
use Behat\Behat\Context\Context;
use Webmozart\Assert\Assert;

final class BookingContext implements Context
{
    /** @var BookingRepository */
    private $bookingRepository;

    public function __construct(BookingRepository $bookingRepository)
    {
        $this->bookingRepository = $bookingRepository;
    }

    /**
     * @Then the pet :pet has been booked
     */
    public function thePetHasBeenBooked(Pet $pet)
    {
        Assert::notNull($this->bookingRepository->findOneBy(['pet' => $pet]), 'Booking was not found');
    }
}
