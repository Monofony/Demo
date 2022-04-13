<?php

declare(strict_types=1);

namespace App\Tests\Behat\Page\Backend\Pet;

use Monofony\Bridge\Behat\Crud\AbstractIndexPage;

final class IndexPage extends AbstractIndexPage
{
    public function getRouteName(): string
    {
        return 'app_backend_pet_index';
    }
}
