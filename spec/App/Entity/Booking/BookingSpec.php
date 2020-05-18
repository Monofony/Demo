<?php

namespace spec\App\Entity\Booking;

use App\Entity\Animal\Animal;
use App\Entity\Booking\Booking;
use App\Entity\Customer\Customer;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BookingSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Booking::class);
    }

    function it_has_no_default_id(): void
    {
        $this->getId()->shouldReturn(null);
    }

    function it_has_no_default_animal()
    {
        $this->getAnimal()->shouldReturn(null);
    }

    function it_has_a_animal(Animal $animal)
    {
        $this->setAnimal($animal);
        $this->getAnimal()->shouldReturn($animal);
    }

    function it_has_no_default_customer()
    {
        $this->getCustomer()->shouldReturn(null);
    }

    function it_has_a_customer(Customer $customer)
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

    function it_has_no_default_created_at()
    {
        $this->getCreatedAt()->shouldReturn(null);
    }

    function it_has_a_created_at(\DateTime $dateTime)
    {
        $this->setCreatedAt($dateTime);
        $this->getCreatedAt()->shouldReturn($dateTime);
    }

    function it_has_no_default_validate_At()
    {
        $this->getValidateAt()->shouldReturn(null);
    }

    function it_has_a_validate_At(\DateTime $dateTime)
    {
        $this->setValidateAt($dateTime);
        $this->getValidateAt()->shouldReturn($dateTime);
    }
}
