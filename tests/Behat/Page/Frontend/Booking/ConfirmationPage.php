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

namespace App\Tests\Behat\Page\Frontend\Booking;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;

final class ConfirmationPage extends SymfonyPage
{
    public function getRouteName(): string
    {
        return 'app_frontend_booking_confirmation';
    }

    public function isRequestSend(): bool
    {
        return $this->getDocument()->hasContent('See the reservation details');
    }
}
