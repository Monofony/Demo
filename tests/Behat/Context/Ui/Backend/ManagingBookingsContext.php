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

use App\Entity\Booking\Booking;
use App\Tests\Behat\Page\Backend\Booking\IndexPage;
use App\Tests\Behat\Page\Backend\Booking\ShowPage;
use Behat\Behat\Context\Context;
use Webmozart\Assert\Assert;

final class ManagingBookingsContext implements Context
{
    /** @var IndexPage */
    private $indexPage;

    /** @var ShowPage */
    private $showPage;

    public function __construct(IndexPage $indexPage, ShowPage $showPage)
    {
        $this->indexPage = $indexPage;
        $this->showPage = $showPage;
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

    /**
     * @Given /^I want to validate (this booking)$/
     */
    public function iWantToValidateThisBooking(Booking $booking)
    {
        $this->showPage->open(['id' => $booking->getId()]);
    }

    /**
     * @When I validate it
     */
    public function iValidateIt()
    {
        $this->showPage->validateBooking();
    }

    /**
     * @Then I should see this booking has been validated in the list
     */
    public function iShouldSeeThisBookingHasBeenValidatedInTheList()
    {
        $this->indexPage->open();
        Assert::true($this->indexPage->isSingleResourceOnPage(['status' => 'Validated']));
    }

    /**
     * @Given /^I want to cancel (this booking)$/
     */
    public function iWantToCancelThisBooking(Booking $booking)
    {
        $this->showPage->open(['id' => $booking->getId()]);
    }

    /**
     * @When I cancel it
     */
    public function iCancelIt()
    {
        $this->showPage->cancelBooking();
    }

    /**
     * @Then I should see this booking has been canceled in the list
     */
    public function iShouldSeeThisBookingHasBeenCanceledInTheList()
    {
        $this->indexPage->open();
        Assert::true($this->indexPage->isSingleResourceOnPage(['status' => 'Canceled']));
    }
}
