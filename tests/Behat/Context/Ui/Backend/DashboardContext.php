<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\Ui\Backend;

use App\Tests\Behat\Page\Backend\DashboardPage;
use Behat\Behat\Context\Context;
use Webmozart\Assert\Assert;

class DashboardContext implements Context
{
    /** @var DashboardPage */
    private $dashboardPage;

    public function __construct(DashboardPage $dashboardPage)
    {
        $this->dashboardPage = $dashboardPage;
    }

    /**
     * @When I open administration dashboard
     */
    public function iOpenAdministrationDashboard()
    {
        $this->dashboardPage->open();
    }

    /**
     * @Then I should see :number new animals in the list
     */
    public function iShouldSeeNewAnimalsInTheList($number)
    {
        Assert::same($this->dashboardPage->getNumberOfNewAnimalsInTheList(), (int) $number);
    }

    /**
     * @Then I should see :number new bookings in the list
     */
    public function iShouldSeeNewBookingsInTheList($number)
    {
        Assert::same($this->dashboardPage->getNumberOfNewBookingsInTheList(), (int) $number);
    }

    /**
     * @Then I should see :number new customers in the list
     */
    public function iShouldSeeNewCustomersInTheList($number)
    {
        Assert::same($this->dashboardPage->getNumberOfNewCustomersInTheList(), (int) $number);
    }

    /**
     * @Then I should see :number new customers
     */
    public function iShouldSeeNewCustomers($number)
    {
        Assert::same($this->dashboardPage->getNumberOfNewCustomers(), (int) $number);
    }

    /**
     * @Then I should see :number new pets
     */
    public function iShouldSeeNewPets($number)
    {
        Assert::same($this->dashboardPage->getNumberOfNewPets(), (int) $number);
    }

    /**
     * @Then I should see :number new bookings
     */
    public function iShouldSeeNewBookings($number)
    {
        Assert::same($this->dashboardPage->getNumberOfNewBookings(), (int) $number);
    }
}
