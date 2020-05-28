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

namespace App\Tests\Behat\Page\Frontend\Animal;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;

final class IndexPage extends SymfonyPage
{
    public function getRouteName(): string
    {
        return 'app_frontend_animal_index';
    }

    public function isAnimalOnList($name)
    {
        return null !== $this->getDocument()->find('css', sprintf('.header:contains("%s")', $name));
    }
}
