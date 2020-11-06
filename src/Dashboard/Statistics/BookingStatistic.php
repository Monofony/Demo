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

namespace App\Dashboard\Statistics;

use App\Repository\BookingRepository;
use Monofony\Component\Admin\Dashboard\Statistics\StatisticInterface;
use Symfony\Component\Templating\EngineInterface;

final class BookingStatistic implements StatisticInterface
{
    /** @var BookingRepository */
    private $bookingRepository;

    /** @var EngineInterface */
    private $engine;

    public function __construct(BookingRepository $bookingRepository, EngineInterface $engine)
    {
        $this->bookingRepository = $bookingRepository;
        $this->engine = $engine;
    }

    public function generate(): string
    {
        $amountBookings = $this->bookingRepository->countBookings();

        return $this->engine->render('backend/dashboard/statistics/_amount_of_bookings.html.twig', [
            'amountOfBookings' => $amountBookings,
        ]);
    }
}
