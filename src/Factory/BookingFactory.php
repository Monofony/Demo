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

namespace App\Factory;

use App\Entity\Animal\Pet;
use App\Entity\Booking\Booking;
use Sylius\Component\Customer\Context\CustomerContextInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

final class BookingFactory implements FactoryInterface
{
    /** @var CustomerContextInterface */
    private $customerContext;

    /** @var FactoryInterface */
    private $factory;

    public function __construct(CustomerContextInterface $customerContext, FactoryInterface $factory)
    {
        $this->customerContext = $customerContext;
        $this->factory = $factory;
    }

    public function createNew(): Booking
    {
        return $this->factory->createNew();
    }

    public function createForPet(Pet $pet): Booking
    {
        $booking = $this->createNew();
        $booking->setPet($pet);
        $booking->setCustomer($this->customerContext->getCustomer());

        return $booking;
    }
}
