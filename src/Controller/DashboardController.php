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

namespace App\Controller;

use App\Dashboard\BookingsDataProvider;
use App\Repository\BookingRepository;
use Monofony\Contracts\Admin\Dashboard\DashboardStatisticsProviderInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;

final class DashboardController
{
    public function __construct(private DashboardStatisticsProviderInterface $statisticsProvider, private Environment $templating, private BookingRepository $bookingRepository, private RouterInterface $router, private BookingsDataProvider $bookingsDataProvider)
    {
    }

    public function indexAction(): Response
    {
        $statistics = $this->statisticsProvider->getStatistics();
        $data = ['statistics' => $statistics];

        $data['bookings_summary'] = $this->bookingsDataProvider->getLastYearBookingsSummary();

        return new Response($this->templating->render('backend/index.html.twig', $data));
    }
}
