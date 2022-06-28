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

namespace App\Tests\Behat\Context\Ui\Frontend;

use App\Entity\Animal\Pet;
use App\Tests\Behat\Page\Frontend\Account\LoginPage;
use App\Tests\Behat\Page\Frontend\Booking\SummaryPage;
use Behat\Behat\Context\Context;
use Webmozart\Assert\Assert;

class BookingContext implements Context
{
    public function __construct(
        private SummaryPage $summaryPage,
        private LoginPage $loginPage,
    ) {
    }

    /**
     * @Given /^I want to ask for a visit (this pet)$/
     * @Given /^I try to ask for a visit (this pet)$/
     */
    public function iWantToAskForAVisitThisPet(Pet $pet): void
    {
        $this->summaryPage->tryToOpen(['slug' => $pet->getSlug()]);
    }

    /**
     * @Given I confirm my choice
     */
    public function iConfirmMyChoice(): void
    {
        $this->summaryPage->confirmMyChoice();
    }

    /**
     * @Then I should be redirected to login page
     */
    public function iShouldBeRedirectedToLoginPage(): void
    {
        Assert::true($this->loginPage->isOpen(), 'User should be on login page but they are not.');
    }
}
