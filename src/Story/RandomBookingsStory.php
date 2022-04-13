<?php

namespace App\Story;

use App\Factory\BookingFactory;
use Zenstruck\Foundry\Story;

final class RandomBookingsStory extends Story
{
    public function build(): void
    {
        BookingFactory::createMany(10);
    }
}
