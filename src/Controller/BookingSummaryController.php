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

namespace App\Controller;

use App\Entity\Animal\Pet;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class BookingSummaryController extends AbstractController
{
    #[Route(path: '/bookings/{slug}/summary', name: 'app_frontend_booking_summary')]
    public function __invoke(Pet $pet): Response
    {
        return $this->render('frontend/booking/summary.html.twig', [
            'pet' => $pet,
        ]);
    }
}
