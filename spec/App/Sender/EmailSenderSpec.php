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

namespace spec\App\Sender;

use App\Entity\Booking\Booking;
use App\Sender\EmailSender;
use Monofony\Contracts\Core\Model\Customer\CustomerInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Mailer\Sender\SenderInterface;

class EmailSenderSpec extends ObjectBehavior
{
    function let(SenderInterface $sender)
    {
        $this->beConstructedWith($sender);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(EmailSender::class);
    }

    function it_sent_emails_for_canceled_bookings(Booking $booking, SenderInterface $sender, CustomerInterface $customer)
    {
        $booking->getCustomer()->willReturn($customer);
        $customer->getEmail()->willReturn('test@example.com');

        $sender->send('canceled_booking', ['test@example.com'], ['booking' => $booking])->shouldBeCalled();

        $this->sendEmailForCanceledBooking($booking);
    }
}
