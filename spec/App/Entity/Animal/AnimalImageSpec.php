<?php

namespace spec\App\Entity\Animal;

use App\Entity\Animal\Animal;
use App\Entity\Animal\AnimalImage;
use App\Entity\Media\File;
use PhpSpec\ObjectBehavior;

class AnimalImageSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(AnimalImage::class);
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

    function it_has_no_animal_by_defaut(): void
    {
        $this->getAnimal()->shouldReturn(null);
    }

    function its_animal_is_mutable(Animal $animal): void
    {
        $this->setAnimal($animal);

        $this->getAnimal()->shouldReturn($animal);
    }
}
