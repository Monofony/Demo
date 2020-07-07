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

use App\BookingStates;
use App\Entity\Booking\Booking;
use App\Repository\PetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sylius\Component\Customer\Context\CustomerContextInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

final class CreateBookingAction extends AbstractController
{
    /** @var PetRepository */
    private $petRepository;

    /** @var CustomerContextInterface */
    private $customerContext;

    /** @var EntityManagerInterface*/
    private $manager;

    public function __construct(
        PetRepository $petRepository,
        CustomerContextInterface $customerContext,
        EntityManagerInterface $entityManager
    ) {
        $this->petRepository = $petRepository;
        $this->customerContext = $customerContext;
        $this->manager = $entityManager;
    }

    /**
     * @Route("/bookings/{slug}/create", name="app_frontend_booking_create")
     */
    public function __invoke(string $slug)
    {
        $booking = new Booking();
        $pet = $this->petRepository->findOneBy(['slug' => $slug]);
        $booking->setPet($pet);
        $booking->setCustomer($this->customerContext->getCustomer());
        $booking->setCreatedAt(new \DateTime('now'));
        $booking->setStatus(BookingStates::NEW);

        $this->manager->persist($booking);
        $this->manager->flush();

        return $this->redirectToRoute('app_frontend_booking_confirmation', ['idBooking' => $booking->getId()]);
    }
}
