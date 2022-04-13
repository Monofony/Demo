<?php

declare(strict_types=1);

namespace App\Tests\Behat\Page\Backend\Booking;

use Monofony\Bridge\Behat\Crud\AbstractIndexPage;

final class IndexPage extends AbstractIndexPage
{
    public function getRouteName(): string
    {
        return 'app_backend_booking_index';
    }
}
