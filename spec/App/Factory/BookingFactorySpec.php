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

namespace spec\App\Factory;

use App\Entity\Animal\Pet;
use App\Entity\Booking\Booking;
use App\Factory\BookingFactory;
use Monofony\Contracts\Core\Model\Customer\CustomerInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Customer\Context\CustomerContextInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

class BookingFactorySpec extends ObjectBehavior
{
    function let(CustomerContextInterface $customerContext, FactoryInterface $factory)
    {
        $this->beConstructedWith($customerContext, $factory);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(BookingFactory::class);
    }

    function it_is_a_factory(): void
    {
        $this->shouldImplement(FactoryInterface::class);
    }

    function it_creates_new_bookings(Booking $booking, FactoryInterface $factory): void
    {
        $factory->createNew()->willReturn($booking);

        $this->createNew()->shouldReturn($booking);
    }

    function it_creates_new_bookings_for_a_specific_pet(
        CustomerInterface $customer,
        CustomerContextInterface $customerContext,
        Booking $booking,
        Pet $pet,
        FactoryInterface $factory
    ): void {
        $customerContext->getCustomer()->willReturn($customer);
        $factory->createNew()->willReturn($booking);

        $booking->setPet($pet)->shouldBeCalled();
        $booking->setCustomer($customer)->shouldBeCalled();

        $this->createForPet($pet);
    }
}
