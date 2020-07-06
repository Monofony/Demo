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

    public function __construct(ConfirmationPage $confirmationPage, SummaryPage $summaryPage)
    {
        $this->confirmationPage = $confirmationPage;
        $this->summaryPage = $summaryPage;
    }

    /**
     * @Given /^I want to ask for a visit (this pet)$/
     */
    public function iWantToAskForAVisitThisPet(Pet $animal)
    {
        $this->summaryPage->open(['slug' => $animal->getSlug()]);
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

}
