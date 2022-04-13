<?php

declare(strict_types=1);

namespace App\Entity\Booking;

use App\Entity\Animal\Pet;
use App\Entity\Customer\Customer;
use App\Entity\Customer\CustomerInterface;
use App\Entity\IdentifiableTrait;
use App\Repository\BookingRepository;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Resource\Model\ResourceInterface;

#[ORM\Entity(repositoryClass: BookingRepository::class)]
class Booking implements ResourceInterface
{
    use IdentifiableTrait;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $createdAt;

    #[ORM\ManyToOne(targetEntity: Pet::class)]
    private ?Pet $Pet = null;

    #[ORM\ManyToOne(targetEntity: Customer::class, inversedBy: 'bookings')]
    private ?CustomerInterface $booker = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
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
        return $this->Pet;
    }

    public function setPet(?Pet $Pet): void
    {
        $this->Pet = $Pet;
    }

    public function getBooker(): ?CustomerInterface
    {
        return $this->booker;
    }

    public function setBooker(?CustomerInterface $booker): void
    {
        $this->booker = $booker;
    }
}
