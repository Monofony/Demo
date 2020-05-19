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

namespace App\Tests\Behat\Page\Backend\Booking;

use Monofony\Bundle\AdminBundle\Tests\Behat\Crud\AbstractIndexPage;
use Monofony\Bundle\AdminBundle\Tests\Behat\Crud\IndexPageInterface;

final class IndexPage extends AbstractIndexPage implements IndexPageInterface
{
    public function getRouteName(): string
    {
        return 'app_backend_booking_index';
    }
}
