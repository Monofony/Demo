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

namespace spec\App\Modifier;

use App\Entity\Booking\Booking;
use App\Modifier\BookingModifier;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BookingModifierSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(BookingModifier::class);
    }

    function it_updates_validation_date(Booking $booking)
    {
        $booking->setFamilyContactedAt(Argument::type(\DateTimeInterface::class))->shouldBeCalled();

        $this->updateFamilyContactDate($booking);
    }
}
