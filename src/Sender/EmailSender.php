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

namespace App\Sender;

use App\Entity\Booking\Booking;
use Sylius\Component\Mailer\Sender\SenderInterface;

final class EmailSender
{
    public function __construct(private SenderInterface $sender)
    {
    }

    public function sendEmailForCanceledBooking(Booking $booking): void
    {
        $this->sender->send('canceled_booking', [$booking->getCustomer()->getEmail()], ['booking' => $booking]);
    }
}
