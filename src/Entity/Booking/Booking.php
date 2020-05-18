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

use App\Entity\Animal\Animal;
use App\Entity\Customer\Customer;
use App\Entity\IdentifiableTrait;
use Doctrine\ORM\Mapping as ORM;

final class Booking
{
    use IdentifiableTrait;

    /** @var Animal|null */
    private $animal;

    /** @var Customer|null */
    private $customer;

    /** @var string|null */
    private $status;

    /** @var \DateTimeInterface|null */
    private $createdAt;

    /** @var \DateTimeInterface|null */
    private $validateAt;

    /**
     * @return Animal|null
     */
    public function getAnimal(): ?Animal
    {
        return $this->animal;
    }

    /**
     * @param Animal|null $animal
     */
    public function setAnimal(?Animal $animal): void
    {
        $this->animal = $animal;
    }

    /**
     * @return Customer|null
     */
    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    /**
     * @param Customer|null $customer
     */
    public function setCustomer(?Customer $customer): void
    {
        $this->customer = $customer;
    }

    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param string|null $status
     */
    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTimeInterface|null $createdAt
     */
    public function setCreatedAt(?\DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getValidateAt(): ?\DateTimeInterface
    {
        return $this->validateAt;
    }

    /**
     * @param \DateTimeInterface|null $validateAt
     */
    public function setValidateAt(?\DateTimeInterface $validateAt): void
    {
        $this->validateAt = $validateAt;
    }
}
