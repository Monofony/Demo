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

namespace App\Dashboard;

final class BookingsSummary
{
    /** @var array */
    private $monthsBookingsMap = [];

    public function __construct(
        \DateTimeInterface $startDate,
        \DateTimeInterface $endDate,
        array $bookingsData
    ) {
        $period = new \DatePeriod($startDate, \DateInterval::createFromDateString('1 month'), $endDate);

        /** @var \DateTimeInterface $date */
        foreach ($period as $date) {
            $periodName = $date->format('m.y');
            if (!isset($bookingsData[$periodName])) {
                $bookingsData[$periodName] = 0;
            }
        }

        uksort($bookingsData, function (string $date1, string $date2) {
            return \DateTime::createFromFormat('m.y', $date1) <=> \DateTime::createFromFormat('m.y', $date2);
        });

        $this->monthsBookingsMap = $bookingsData;
    }

    public function getMonths(): array
    {
        return array_keys($this->monthsBookingsMap);
    }

    public function getValues(): array
    {
        return array_values($this->monthsBookingsMap);
    }
}
