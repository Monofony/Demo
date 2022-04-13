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

use App\Tests\Behat\Page\Backend\DashboardPage;
use Behat\Behat\Context\Context;
use Webmozart\Assert\Assert;

class DashboardContext implements Context
{
    public function __construct(private DashboardPage $dashboardPage)
    {
    }

    /**
     * @When I open administration dashboard
     */
    public function iOpenAdministrationDashboard()
    {
        $this->dashboardPage->open();
    }

    /**
     * @Then I should see :amount new customers in the list
     */
    public function iShouldSeeNewCustomersInTheList(int $amount)
    {
        Assert::same($this->dashboardPage->getNumberOfNewCustomersInTheList(), $amount);
    }

    /**
     * @Then I should see :amount new customers
     */
    public function iShouldSeeNewCustomers(int $amount): void
    {
        Assert::same($this->dashboardPage->getNumberOfNewCustomers(), $amount);
    }

    /**
     * @Then I should see :amount new pets
     */
    public function iShouldSeeNewPets(int $amount): void
    {
        Assert::same($this->dashboardPage->getNumberOfNewPets(), $amount);
    }

    /**
     * @Then I should see :amount new pets in the list
     */
    public function iShouldSeeNewPetsInTheList(int $amount): void
    {
        Assert::same($this->dashboardPage->getNumberOfNewPetsInTheList(), $amount);
    }

    /**
     * @Then I should see :amount new bookings
     */
    public function iShouldSeeNewBookings(int $amount): void
    {
        Assert::same($this->dashboardPage->getNumberOfNewBookings(), $amount);
    }

    /**
     * @Then I should see :amount new bookings in the list
     */
    public function iShouldSeeNewBookingsInTheList(int $amount): void
    {
        Assert::same($this->dashboardPage->getNumberOfNewBookingsInTheList(), $amount);
    }
}
