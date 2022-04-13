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

use App\Factory\LocaleFactory;
use Zenstruck\Foundry\Story;

final class DefaultLocalesStory extends Story
{
    public function build(): void
    {
        LocaleFactory::new()->withDefaultCode()->create();
    }
}
