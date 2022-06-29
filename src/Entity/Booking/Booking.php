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

namespace App\Entity\Booking;

use App\BookingStates;
use App\Entity\Animal\Pet;
use App\Entity\Customer\Customer;
use App\Entity\Customer\CustomerInterface;
use App\Entity\IdentifiableTrait;
use App\Repository\BookingRepository;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Resource\Annotation\SyliusCrudRoutes;
use Sylius\Component\Resource\Annotation\SyliusRoute;
use Sylius\Component\Resource\Model\ResourceInterface;

#[ORM\Entity(repositoryClass: BookingRepository::class)]
#[SyliusCrudRoutes(
    alias: 'app.booking',
    path: 'admin/bookings',
    section: 'backend',
    templates: 'backend/crud',
    grid: 'app_booking',
    only: ['index', 'show'],
    vars: [
        'all' => [
            'subheader' => 'app.ui.manage_your_bookings',
        ],
        'index' => [
            'icon' => 'fax',
        ],
    ],
)]
#[SyliusRoute(
    name: 'sylius_frontend_account_booking',
    path: '/account/bookings',
    methods: ['GET'],
    controller: 'app.controller.booking::indexAction',
    template: 'frontend/account/bookings.html.twig',
    grid: 'app_frontend_booking',
)]
#[SyliusRoute(
    name: 'app_backend_partial_booking_latest',
    path: '/_partial/bookings/latest/{count}',
    methods: ['GET'],
    controller: 'app.controller.booking::indexAction',
    template: '$template',
    repository: ['method' => 'findLatest', 'arguments' => ['!!int $count']],
)]
class Booking implements ResourceInterface
{
    use IdentifiableTrait;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $createdAt;

    #[ORM\ManyToOne(targetEntity: Pet::class)]
    private ?Pet $pet = null;

    #[ORM\ManyToOne(targetEntity: Customer::class, inversedBy: 'bookings')]
    private ?CustomerInterface $booker = null;

    #[ORM\Column(type: 'string')]
    private string $status;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->status = BookingStates::NEW;
    }

    public static function createForPetAndBooker(Pet $pet, CustomerInterface $booker): self
    {
        $booking = new self();
        $booking->setPet($pet);
        $booking->setBooker($booker);

        return $booking;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getPet(): ?Pet
    {
        return $this->pet;
    }

    public function setPet(?Pet $pet): void
    {
        $this->pet = $pet;
    }

    public function getBooker(): ?CustomerInterface
    {
        return $this->booker;
    }

    public function setBooker(?CustomerInterface $booker): void
    {
        $this->booker = $booker;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }
}
