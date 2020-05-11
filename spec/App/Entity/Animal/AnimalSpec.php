<?php

namespace spec\App\Entity\Animal;

use App\Entity\Animal\Animal;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AnimalSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Animal::class);
    }

    function it_has_no_default_id(): void
    {
        $this->getId()->shouldReturn(null);
    }

    function it_has_no_default_name()
    {
        $this->getName()->shouldReturn(null);
    }

    function it_has_a_name()
    {
        $this->setName('Mickey');
        $this->getName()->shouldReturn('Mickey');
    }

    function it_has_no_default_slug()
    {
        $this->getSlug()->shouldReturn(null);
    }

    function it_has_a_slug()
    {
        $this->setSlug('Yes');
        $this->getSlug()->shouldReturn('Yes');
    }

    function it_has_no_default_description()
    {
        $this->getDescription()->shouldReturn(null);
    }

    function it_has_a_description()
    {
        $this->setDescription('Yes');
        $this->getDescription()->shouldReturn('Yes');
    }

    function it_has_no_default_size()
    {
        $this->getSize()->shouldReturn(null);
    }

    function it_has_a_size()
    {
        $this->setSize(0.86);
        $this->getSize()->shouldReturn(0.86);
    }

    function it_has_no_default_size_unit()
    {
        $this->getSizeUnit()->shouldReturn(null);
    }

    function it_has_a_size_unit()
    {
        $this->setSizeUnit('centimeter');
        $this->getSizeUnit()->shouldReturn('centimeter');
    }

    function it_has_no_default_main_color()
    {
        $this->getMainColor()->shouldReturn(null);
    }

    function it_has_a_main_color()
    {
        $this->setMainColor('Zinzolin');
        $this->getMainColor()->shouldReturn('Zinzolin');
    }
}
