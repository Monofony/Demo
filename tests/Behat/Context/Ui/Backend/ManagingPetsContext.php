<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\Ui\Backend;

use App\Tests\Behat\Page\Backend\Pet\IndexPage;
use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Webmozart\Assert\Assert;

final class ManagingPetsContext implements Context
{
    public function __construct(private IndexPage $indexPage)
    {
    }

    /**
     * @When I want to browse all pets
     */
    public function iWantToBrowseAllPets(): void
    {
        $this->indexPage->open();
    }

    /**
     * @Then I should see :amount pets in the list
     */
    public function iShouldSeePetsInTheList(int $amount): void
    {
        Assert::eq($this->indexPage->countItems(), $amount);
    }

    /**
     * @Then I should see the pet :name in the list
     */
    public function iShouldSeeThePetInTheList(string $name): void
    {
        Assert::true($this->indexPage->isSingleResourceOnPage(['name' => $name]));
    }
}
