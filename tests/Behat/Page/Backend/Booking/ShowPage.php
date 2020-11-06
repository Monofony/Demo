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

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;

final class ShowPage extends SymfonyPage
{
    public function getRouteName(): string
    {
        return 'app_backend_booking_show';
    }

    public function contactFamilyBooking(): void
    {
        $this->getDocument()->pressButton('Contact family');
    }

    public function cancelBooking(): void
    {
        $this->getDocument()->pressButton('Cancel');
    }
}
