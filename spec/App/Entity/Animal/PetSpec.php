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
use App\Entity\Animal\PetImage;
use App\Entity\Taxonomy\TaxonInterface;
use Doctrine\Common\Collections\Collection;
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

    function it_should_have_new_status_by_default(): void
    {
        $this->getStatus()->shouldReturn('new');
    }

    function its_status_is_mutable(): void
    {
        $this->setStatus('booked');

        $this->getStatus()->shouldReturn('booked');
    }

    function it_is_not_enabled_by_default(): void
    {
        $this->isEnabled()->shouldBe(false);
    }

    function it_can_be_enabled(): void
    {
        $this->setEnabled(true);

        $this->isEnabled()->shouldBe(true);
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

    function it_has_no_sex_by_default(): void
    {
        $this->getSex()->shouldReturn(null);
    }

    function its_sex_is_mutable(): void
    {
        $this->setSex('female');

        $this->getSex()->shouldReturn('female');
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

    function it_initializes_image_collection_by_default()
    {
        $this->getImages()->shouldHaveType(Collection::class);
    }

    function it_adds_images(PetImage $image)
    {
        $image->setPet($this)->shouldBeCalled();

        $this->addImage($image);

        $this->hasImage($image)->shouldReturn(true);
    }

    function it_removes_images(PetImage $image)
    {
        $this->addImage($image);

        $image->setPet(null)->shouldBeCalled();

        $this->removeImage($image);

        $this->hasImage($image)->shouldReturn(false);
    }

    function it_has_no_first_image_by_default(): void
    {
        $this->getFirstImage()->shouldReturn(null);
    }

    function it_can_get_first_image(PetImage $firstImage, PetImage $secondImage): void
    {
        $this->addImage($firstImage);
        $this->addImage($secondImage);

        $this->getFirstImage()->shouldReturn($firstImage);
    }
}
