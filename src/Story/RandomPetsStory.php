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

namespace App\Story;

use App\Factory\PetFactory;
use Zenstruck\Foundry\Story;

final class RandomPetsStory extends Story
{
    public function build(): void
    {
        PetFactory::createMany(100);
    }
}
