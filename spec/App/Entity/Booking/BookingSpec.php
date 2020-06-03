<?php

namespace spec\App\Entity\Booking;

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

    function it_has_no_default_animal()
    {
        $this->getAnimal()->shouldReturn(null);
    }

    function it_has_a_animal(Pet $animal)
    {
        $this->setAnimal($animal);
        $this->getAnimal()->shouldReturn($animal);
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
        $this->setStatus('En cours');
        $this->getStatus()->shouldReturn('En cours');
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

    function it_has_no_default_validation_date()
    {
        $this->getValidatedAt()->shouldReturn(null);
    }

    function it_has_a_validation_date(\DateTime $dateTime)
    {
        $this->setValidatedAt($dateTime);
        $this->getValidatedAt()->shouldReturn($dateTime);
    }
}
