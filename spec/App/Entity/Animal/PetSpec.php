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

namespace spec\App\Entity\Animal;

use App\Entity\Animal\Pet;
use App\Entity\Taxonomy\TaxonInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Resource\Model\ResourceInterface;

class PetSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(Pet::class);
    }

    function it_is_a_resource(): void
    {
        $this->shouldImplement(ResourceInterface::class);
    }

    function it_has_no_name_by_default(): void
    {
        $this->getName()->shouldReturn(null);
    }

    function its_name_is_mutable(): void
    {
        $this->setName('Mickey');

        $this->getName()->shouldReturn('Mickey');
    }

    function it_has_no_slug_by_default(): void
    {
        $this->getSlug()->shouldReturn(null);
    }

    function its_slug_is_mutable(): void
    {
        $this->setSlug('mickey');

        $this->getSlug()->shouldReturn('mickey');
    }

    function it_has_no_description_by_default(): void
    {
        $this->getDescription()->shouldReturn(null);
    }

    function its_description_is_mutable(): void
    {
        $this->setDescription('My name is Mickey');

        $this->getDescription()->shouldReturn('My name is Mickey');
    }

    function it_has_no_size_by_default(): void
    {
        $this->getSize()->shouldReturn(null);
    }

    function its_size_is_mutable(): void
    {
        $this->setSize(0.42);

        $this->getSize()->shouldReturn(0.42);
    }

    function it_has_no_size_unit_by_default(): void
    {
        $this->getSizeUnit()->shouldReturn(null);
    }

    function its_size_unit_is_mutable(): void
    {
        $this->setSizeUnit('centimeter');

        $this->getSizeUnit()->shouldReturn('centimeter');
    }

    function it_has_no_main_color_by_default(): void
    {
        $this->getMainColor()->shouldReturn(null);
    }

    function its_main_color_is_mutable(): void
    {
        $this->setMainColor('white');

        $this->getMainColor()->shouldReturn('white');
    }

    function it_has_no_taxon_by_default()
    {
        $this->getTaxon()->shouldReturn(null);
    }

    function its_taxon_is_mutable(TaxonInterface $taxon)
    {
        $this->setTaxon($taxon);

        $this->getTaxon()->shouldReturn($taxon);
    }
}
