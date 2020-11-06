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

namespace App\Tests\Behat\Context\Ui\Frontend;

use App\Entity\Animal\Pet;
use App\Tests\Behat\Page\Frontend\Account\LoginPage;
use App\Tests\Behat\Page\Frontend\Booking\ConfirmationPage;
use App\Tests\Behat\Page\Frontend\Booking\SummaryPage;
use Behat\Behat\Context\Context;
use Webmozart\Assert\Assert;

final class BookingContext implements Context
{
    /** @var ConfirmationPage */
    private $confirmationPage;

    /** @var SummaryPage */
    private $summaryPage;

    /** @var LoginPage */
    private $loginPage;

    public function __construct(
        ConfirmationPage $confirmationPage,
        SummaryPage $summaryPage,
        LoginPage $loginPage
    ) {
        $this->confirmationPage = $confirmationPage;
        $this->summaryPage = $summaryPage;
        $this->loginPage = $loginPage;
    }

    /**
     * @Given /^I want to ask for a visit (this pet)$/
     * @Given /^I try to ask for a visit (this pet)$/
     */
    public function iWantToAskForAVisitThisPet(Pet $animal)
    {
        $this->summaryPage->tryToOpen(['slug' => $animal->getSlug()]);
    }

    /**
     * @Given I confirm my choice
     */
    public function iConfirmMyChoice()
    {
        $this->summaryPage->confirmMyChoice();
    }

    /**
     * @Given I should see my request has been send
     */
    public function iShouldSeeMyRequestHasBeenSend()
    {
        Assert::true($this->confirmationPage->isRequestSend());
    }

    /**
     * @Given I should be redirected to login page
     */
    public function iShouldBeRedirectedToLoginPage()
    {
        Assert::true($this->loginPage->isOpen(), 'User should be on login page but they are not.');
    }
}
