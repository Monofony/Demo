<?php

namespace App\Story;

use App\Factory\PetFactory;
use Zenstruck\Foundry\Story;

final class RandomPetsStory extends Story
{
    public function build(): void
    {
        PetFactory::createMany(40);
    }
}
