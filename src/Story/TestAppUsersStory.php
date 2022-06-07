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

final class TestAppUsersStory extends Story
{
    public function build(): void
    {
        AppUserFactory::createOne([
            'email' => 'api@sylius.com',
            'username' => 'sylius',
            'password' => 'sylius',
            'first_name' => 'Sam',
            'last_name' => 'Identifie',
        ]);

        AppUserFactory::createOne([
            'email' => 'another-customer@example.com',
            'username' => 'monofony',
            'password' => 'monofony',
            'first_name' => 'Another',
            'last_name' => 'Customer',
        ]);
    }
}
