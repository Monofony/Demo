<?php

/*
 * This file is part of the Monofony demo project.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Dashboard\Statistics;

use App\Repository\BookingRepository;
use Monofony\Component\Admin\Dashboard\Statistics\StatisticInterface;
use Twig\Environment;

final class BookingStatistic implements StatisticInterface
{
    public function __construct(private BookingRepository $bookingRepository, private Environment $engine)
    {
    }

    public function generate(): string
    {
        $amountBookings = $this->bookingRepository->countBookings();

        return $this->engine->render('backend/dashboard/statistics/_amount_of_bookings.html.twig', [
            'amountOfBookings' => $amountBookings,
        ]);
    }

    public static function getDefaultPriority(): int
    {
        return -2;
    }
}
