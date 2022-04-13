<?php

/*
 * This file is part of Monofony demo project.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Tests\Behat\Page\Backend\Pet;

use Monofony\Bridge\Behat\Behaviour\NamesIt;
use Monofony\Bridge\Behat\Crud\AbstractCreatePage;

final class CreatePage extends AbstractCreatePage
{
    use NamesIt;

    public function getRouteName(): string
    {
        return 'app_backend_pet_create';
    }

    protected function getDefinedElements(): array
    {
        return [
            'name' => '#app_pet_name',
        ];
    }
}
