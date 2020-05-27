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

final class BookingModifier
{
    public function updateValidationDate(Booking $booking): void
    {
        $booking->setValidatedAt(new \DateTimeImmutable());
    }
}
