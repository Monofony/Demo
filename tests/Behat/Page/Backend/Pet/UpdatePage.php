<?php

declare(strict_types=1);

namespace App\Tests\Behat\Page\Backend\Pet;

use Monofony\Bridge\Behat\Behaviour\NamesIt;
use Monofony\Bridge\Behat\Crud\AbstractUpdatePage;

final class UpdatePage extends AbstractUpdatePage
{
    use NamesIt;

    public function getRouteName(): string
    {
        return 'app_backend_pet_update';
    }
}
