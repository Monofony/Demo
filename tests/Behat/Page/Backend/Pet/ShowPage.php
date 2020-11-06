<?php

/*
 * This file is part of the Monofony demo.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Tests\Behat\Page\Backend\Pet;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;

final class ShowPage extends SymfonyPage
{
    public function getRouteName(): string
    {
        return 'app_backend_pet_show';
    }

    public function validatePet(): void
    {
        $this->getDocument()->pressButton('Validate');
    }
}
