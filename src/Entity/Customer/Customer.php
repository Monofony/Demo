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

namespace App\Entity\Customer;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Symfony\Messenger\Processor as MessengerProcessor;
use App\Entity\Booking\Booking;
use App\Entity\User\AppUser;
use App\Message\ChangeAppUserPassword;
use App\Message\RegisterAppUser;
use App\Message\ResetPassword;
use App\Message\ResetPasswordRequest;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Monofony\Contracts\Core\Model\User\AppUserInterface;
use Sylius\Component\Customer\Model\Customer as BaseCustomer;
use Sylius\Component\User\Model\UserInterface;
use Symfony\Component\Validator\Constraints\Valid;
use Webmozart\Assert\Assert;

#[ORM\Entity]
#[ORM\Table(name: 'sylius_customer')]
#[ApiResource(normalizationContext: ['groups' => ['customer:read', 'user:read']], denormalizationContext: ['groups' => ['customer:write', 'user:write']], validationContext: ['groups' => ['Default', 'sylius']])]
#[Post(openapiContext: ['summary' => 'Registers an app user'], input: RegisterAppUser::class, output: false, processor: MessengerProcessor::class)]
#[Post(uriTemplate: '/request_password', openapiContext: ['summary' => 'Request a new password'], input: ResetPasswordRequest::class, output: false, processor: MessengerProcessor::class)]
#[Post(uriTemplate: '/reset_password/{token}', uriVariables: [], openapiContext: ['summary' => 'Reset password'], input: ResetPassword::class, output: false, processor: MessengerProcessor::class)]
#[Get(security: 'is_granted("ROLE_USER") && object.getUser() == user && object == user.getCustomer()')]
#[Put(security: 'is_granted("ROLE_USER") && object.getUser() == user && object == user.getCustomer()')]
#[Put(uriTemplate: '/customers/{id}/password', openapiContext: ['summary' => 'Change password for logged in customer'], denormalizationContext: ['groups' => ['customer:password:write']], security: 'is_granted("ROLE_USER")', input: ChangeAppUserPassword::class, output: false, processor: MessengerProcessor::class)]
class Customer extends BaseCustomer implements CustomerInterface
{
    #[ORM\OneToOne(mappedBy: 'customer', targetEntity: AppUser::class, cascade: ['persist'])]
    #[Valid]
    private ?UserInterface $user = null;

    #[ORM\OneToMany(mappedBy: 'booker', targetEntity: Booking::class)]
    private Collection $bookings;

    public function __construct()
    {
        parent::__construct();

        $this->bookings = new ArrayCollection();
    }

    public function getUser(): ?UserInterface
    {
        return $this->user;
    }

    public function setUser(?UserInterface $user): void
    {
        if ($this->user === $user) {
            return;
        }

        Assert::nullOrIsInstanceOf($user, AppUserInterface::class);

        $previousUser = $this->user;
        $this->user = $user;

        if ($previousUser instanceof AppUserInterface) {
            $previousUser->setCustomer(null);
        }

        if ($user instanceof AppUserInterface) {
            $user->setCustomer($this);
        }
    }

    /**
     * @return Collection<int, Booking>
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): void
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings[] = $booking;
            $booking->setBooker($this);
        }
    }

    public function removeBooking(Booking $booking): void
    {
        if ($this->bookings->removeElement($booking)) {
            // set the owning side to null (unless already changed)
            if ($booking->getBooker() === $this) {
                $booking->setBooker(null);
            }
        }
    }
}
