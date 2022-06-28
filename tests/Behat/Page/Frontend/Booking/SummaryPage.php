<?php

/*
 * This file is part of the Monofony demo project.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Tests\Behat\Page\Frontend\Booking;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;

class SummaryPage extends SymfonyPage
{
    public function getRouteName(): string
    {
        return 'app_frontend_booking_summary';
    }

    public function confirmMyChoice(): void
    {
        $this->getDocument()->pressButton('Ask for a visit!');
    }
}
