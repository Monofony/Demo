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
use App\Entity\Media\File;
use PhpSpec\ObjectBehavior;

class PetImageSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(PetImage::class);
    }

    function it_is_a_file(): void
    {
        $this->shouldHaveType(File::class);
    }

    function it_has_no_file_by_default(): void
    {
        $this->getFile()->shouldReturn(null);
    }

    function its_file_is_mutable(\SplFileInfo $file): void
    {
        $this->setFile($file);

        $this->getFile()->shouldReturn($file);
    }

    function it_has_no_path_by_defaut(): void
    {
        $this->getPath()->shouldReturn(null);
    }

    function its_path_is_mutable(): void
    {
        $this->setPath('avatar.png');

        $this->getPath()->shouldReturn('avatar.png');
    }

    function it_has_no_pet_by_defaut(): void
    {
        $this->getPet()->shouldReturn(null);
    }

    function its_pet_is_mutable(Pet $animal): void
    {
        $this->setPet($animal);

        $this->getPet()->shouldReturn($animal);
    }
}
