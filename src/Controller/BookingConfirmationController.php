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
use App\Entity\Booking\Booking;
use App\Repository\BookingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Monofony\Contracts\Core\Model\User\AppUserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Webmozart\Assert\Assert;

final class BookingConfirmationController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    #[Route(path: '/bookings/{slug}/confirmation', name: 'app_frontend_booking_confirmation')]
    public function __invoke(Pet $pet): Response
    {
        /** @var BookingRepository $bookingRepository */
        $bookingRepository = $this->entityManager->getRepository(Booking::class);

        /** @var AppUserInterface $user */
        $user = $this->getUser();
        Assert::isInstanceOf($user, AppUserInterface::class);

        $booking = $bookingRepository->findOneByCustomerAndPet($user->getCustomer(), $pet);

        if (null === $booking) {
            throw new NotFoundHttpException('Booking was not found');
        }

        return $this->render('frontend/booking/confirmation.html.twig', [
            'booking' => $booking,
        ]);
    }
}
