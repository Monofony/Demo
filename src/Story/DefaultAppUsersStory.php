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

use App\Factory\AppUserFactory;
use Zenstruck\Foundry\Story;

final class DefaultAppUsersStory extends Story
{
    public function build(): void
    {
        AppUserFactory::createOne([
            'email' => 'customer@example.com',
            'password' => 'password',
        ]);
    }
}
