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
use App\Entity\IdentifiableTrait;
use Doctrine\ORM\Mapping as ORM;
use Monofony\Component\Core\Model\Customer\CustomerInterface;
use Sylius\Component\Resource\Model\TimestampableTrait;

final class Booking
{
    use IdentifiableTrait;

    /** @var Animal|null */
    private $animal;

    /** @var CustomerInterface|null */
    private $customer;

    /** @var string|null */
    private $status;

    use TimestampableTrait;

    /** @var \DateTimeInterface|null */
    private $validateAt;

    public function getAnimal(): ?Animal
    {
        return $this->animal;
    }

    public function setAnimal(?Animal $animal): void
    {
        $this->animal = $animal;
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

    public function getValidateAt(): ?\DateTimeInterface
    {
        return $this->validateAt;
    }

    public function setValidateAt(?\DateTimeInterface $validateAt): void
    {
        $this->validateAt = $validateAt;
    }
}
