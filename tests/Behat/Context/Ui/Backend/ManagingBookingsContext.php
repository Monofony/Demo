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

namespace App\Tests\Behat\Context\Ui\Backend;

use App\Tests\Behat\Page\Backend\Booking\IndexPage;
use Behat\Behat\Context\Context;
use Webmozart\Assert\Assert;

final class ManagingBookingsContext implements Context
{
    /** @var IndexPage */
    private $indexPage;

    public function __construct(IndexPage $indexPage)
    {
        $this->indexPage = $indexPage;
    }

    /**
     * @When I want to see all bookings
     */
    public function iWantToSeeAllBookings()
    {
        $this->indexPage->open();
    }

    /**
     * @Then I should see :nbBookings bookings in the list
     */
    public function iShouldSeeBookingsInTheList(int $nbBookings)
    {
        Assert::eq($this->indexPage->countItems(), $nbBookings);
    }

    /**
     * @Then I should see the booking for the animal :name in the list
     */
    public function iShouldSeeTheBookingForTheAnimalInTheList(string $name)
    {
        Assert::true($this->indexPage->isSingleResourceOnPage(['animal' => $name]));
    }
}
