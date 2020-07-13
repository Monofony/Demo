<?php

namespace spec\App\Entity\Booking;

use App\BookingStates;
use App\Entity\Animal\Pet;
use App\Entity\Booking\Booking;
use Monofony\Component\Core\Model\Customer\CustomerInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Resource\Model\ResourceInterface;

class BookingSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Booking::class);
    }

    function it_is_a_resource(): void
    {
        $this->shouldImplement(ResourceInterface::class);
    }

    function it_has_no_default_id(): void
    {
        $this->getId()->shouldReturn(null);
    }

    function it_has_no_default_pet()
    {
        $this->getPet()->shouldReturn(null);
    }

    function it_has_a_pet(Pet $pet)
    {
        $this->setPet($pet);
        $this->getPet()->shouldReturn($pet);
    }

    function it_has_no_default_customer()
    {
        $this->getCustomer()->shouldReturn(null);
    }

    function it_has_a_customer(CustomerInterface $customer)
    {
        $this->setCustomer($customer);
        $this->getCustomer()->shouldReturn($customer);
    }

    function it_has_no_default_status()
    {
        $this->getStatus()->shouldReturn(null);
    }

    function it_has_a_status()
    {
        $this->setStatus(BookingStates::CANCELED);
        $this->getStatus()->shouldReturn(BookingStates::CANCELED);
    }

    function it_has_no_default_creation_date()
    {
        $this->getCreatedAt()->shouldReturn(null);
    }

    function it_has_a_creation_date(\DateTime $dateTime)
    {
        $this->setCreatedAt($dateTime);
        $this->getCreatedAt()->shouldReturn($dateTime);
    }

    function it_has_no_default_family_contact_date()
    {
        $this->getFamilyContactedAt()->shouldReturn(null);
    }

    function its_family_contact_date_is_mutable(\DateTime $dateTime)
    {
        $this->setFamilyContactedAt($dateTime);
        $this->getFamilyContactedAt()->shouldReturn($dateTime);
    }
}
