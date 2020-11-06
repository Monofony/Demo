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

namespace App\Entity\Booking;

use App\BookingStates;
use App\Entity\Animal\Pet;
use App\Entity\IdentifiableTrait;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Monofony\Contracts\Core\Model\Customer\CustomerInterface;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\TimestampableTrait;

/**
 * @ORM\Entity
 * @ORM\Table(name="app_booking")
 */
class Booking implements ResourceInterface
{
    use IdentifiableTrait;
    use TimestampableTrait;

    /**
     * @var \DateTimeInterface|null
     *
     * @ORM\Column(type="date")
     */
    protected $createdAt;

    /**
     * @var Pet|null
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Animal\Pet")
     */
    private $pet;

    /**
     * @var CustomerInterface|null
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Customer\Customer", inversedBy="bookings")
     */
    private $customer;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string")
     */
    private $status;

    /**
     * @var \DateTimeInterface|null
     *
     * @ORM\Column(type="date", nullable=true)
     */
    private $familyContactedAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime('now');
        $this->status = BookingStates::NEW;
    }

    public function getPet(): ?Pet
    {
        return $this->pet;
    }

    public function setPet(?Pet $pet): void
    {
        $this->pet = $pet;
    }

    public function getCustomer(): ?CustomerInterface
    {
        return $this->customer;
    }

    public function setCustomer(?CustomerInterface $customer): void
    {
        $this->customer = $customer;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }

    public function getFamilyContactedAt(): ?\DateTimeInterface
    {
        return $this->familyContactedAt;
    }

    public function setFamilyContactedAt(?\DateTimeInterface $familyContactedAt): void
    {
        $this->familyContactedAt = $familyContactedAt;
    }
}
