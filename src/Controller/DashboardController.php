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
use Symfony\Component\Templating\EngineInterface;

final class DashboardController
{
    /** @var DashboardStatisticsProviderInterface */
    private $statisticsProvider;

    /** @var EngineInterface */
    private $templating;

    /** @var BookingsDataProvider */
    private $bookingsDataProvider;

    /** @var BookingRepository */
    private $bookingRepository;

    /** @var RouterInterface */
    private $router;

    public function __construct(
        DashboardStatisticsProviderInterface $statisticsProvider,
        EngineInterface $templating,
        BookingRepository $bookingRepository,
        RouterInterface $router,
        BookingsDataProvider $bookingsDataProvider
    ) {
        $this->statisticsProvider = $statisticsProvider;
        $this->templating = $templating;
        $this->bookingRepository = $bookingRepository;
        $this->router = $router;
        $this->bookingsDataProvider = $bookingsDataProvider;
    }

    public function indexAction(): Response
    {
        $statistics = $this->statisticsProvider->getStatistics();
        $data = ['statistics' => $statistics];

        $data['bookings_summary'] = $this->bookingsDataProvider->getLastYearBookingsSummary();

        return new Response($this->templating->render('backend/index.html.twig', $data));
    }
}
