<?php

/*
 * This file is part of Monofony demo project.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace spec\App\Entity\Booking;

use App\Entity\Animal\Pet;
use App\Entity\Booking\Booking;
use App\Entity\Customer\CustomerInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Resource\Model\ResourceInterface;

class BookingSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(Booking::class);
    }

    function it_is_a_resource(): void
    {
        $this->shouldImplement(ResourceInterface::class);
    }

    function it_has_no_pet_by_default(): void
    {
        $this->getPet()->shouldReturn(null);
    }

    function its_pet_is_mutable(Pet $pet): void
    {
        $this->setPet($pet);

        $this->getPet()->shouldReturn($pet);
    }

    function it_has_no_booker_by_default(): void
    {
        $this->getBooker()->shouldReturn(null);
    }

    function it_booker_is_mutable(CustomerInterface $booker)
    {
        $this->setBooker($booker);

        $this->getBooker()->shouldReturn($booker);
    }

    function it_initialize_a_creation_date_by_default()
    {
        $this->getCreatedAt()->shouldNotReturn(null);
    }
}
