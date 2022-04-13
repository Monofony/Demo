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

namespace App\Tests\Behat\Context\Ui\Backend;

use App\Tests\Behat\Page\Backend\Booking\IndexPage;
use Behat\Behat\Context\Context;
use Webmozart\Assert\Assert;

final class ManagingBookingsContext implements Context
{
    public function __construct(private IndexPage $indexPage)
    {
    }

    /**
     * @When I want to browse all bookings
     */
    public function iWantToBrowseAllBookings(): void
    {
        $this->indexPage->open();
    }

    /**
     * @Then I should see :amount bookings in the list
     */
    public function iShouldSeeBookingsInTheList(int $amount): void
    {
        Assert::eq($this->indexPage->countItems(), $amount);
    }

    /**
     * @Then I should see the booking for the pet :name in the list
     */
    public function iShouldSeeTheBookingForThePetInTheList(string $name): void
    {
        Assert::true($this->indexPage->isSingleResourceOnPage(['pet' => $name]));
    }
}
