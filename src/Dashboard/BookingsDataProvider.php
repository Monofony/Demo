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

use App\Repository\BookingRepository;
use Doctrine\ORM\EntityManagerInterface;

final class BookingsDataProvider
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var BookingRepository */
    private $bookingRepository;

    public function __construct(EntityManagerInterface $entityManager, BookingRepository $bookingRepository)
    {
        $this->entityManager = $entityManager;
        $this->bookingRepository = $bookingRepository;
    }

    public function getLastYearBookingsSummary(): BookingsSummary
    {
        $startDate = (new \DateTime('first day of next month last year'));
        $startDate->setTime(0, 0, 0);
        $endDate = (new \DateTime('last day of this month'));
        $endDate->setTime(23, 59, 59);

        /** @psalm-suppress PossiblyUndefinedMethod */
        $queryBuilder = $this->bookingRepository->createQueryBuilder('o')
            ->select("DATE_FORMAT(o.createdAt, '%m.%y') AS date")
            ->addSelect('COUNT(o.id) as total')
            ->andWhere('o.createdAt >= :startDate')
            ->andWhere('o.createdAt <= :endDate')
            ->groupBy('date')
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate)
        ;
        $result = $queryBuilder->getQuery()->getScalarResult();

        $data = [];
        foreach ($result as $item) {
            $data[$item['date']] = (int) $item['total'];
        }

        return new BookingsSummary(
            $startDate,
            $endDate,
            $data
        );
    }
}
