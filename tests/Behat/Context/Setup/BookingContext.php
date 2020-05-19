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

use App\Entity\Animal\Animal;
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
     * @Given /^(this animal) has been booked by (customer "([^"]+)")$/
     */
    public function thereIsABookingForTheAnimal(Animal $animal, CustomerInterface $customer)
    {
        $booking = $this->bookingFactory->create(['animal' => $animal, 'customer' => $customer]);

        $this->manager->persist($booking);
        $this->manager->flush();
        $this->sharedStorage->set('booking', $booking);
    }


}
