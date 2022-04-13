<?php

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
