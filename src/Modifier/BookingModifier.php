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

namespace App\Modifier;

use App\Entity\Booking\Booking;
use Doctrine\Common\Persistence\ObjectManager;
use Sylius\Component\Mailer\Sender\SenderInterface;

final class BookingModifier
{
    /** @var ObjectManager */
    protected $manager;

    /** @var SenderInterface */
    private $sender;

    public function __construct(ObjectManager $manager, SenderInterface $sender)
    {
        $this->manager = $manager;
        $this->sender = $sender;
    }

    public function updateValidationDate(Booking $booking): void
    {
        $booking->setValidatedAt(new \DateTime());
        $this->manager->persist($booking);
        $this->manager->flush();
    }

    public function sendEmailForCanceledBooking(Booking $booking): void
    {
        $this->sender->send('canceled_booking', ['demo-monofony-5b6e94@inbox.mailtrap.io'], ['booking' => $booking]);
    }
}
