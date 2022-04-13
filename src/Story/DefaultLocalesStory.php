<?php

namespace App\Story;

use App\Factory\LocaleFactory;
use Zenstruck\Foundry\Story;

final class DefaultLocalesStory extends Story
{
    public function build(): void
    {
        LocaleFactory::new()->withDefaultCode()->create();
    }
}
