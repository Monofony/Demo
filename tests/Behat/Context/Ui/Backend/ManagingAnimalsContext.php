<?php

/*
 * This file is part of monofony_demo.
 *
 * (c) Mobizel
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Tests\Behat\Context\Ui\Backend;

use App\Tests\Behat\Page\Backend\Animal\IndexPage;
use Behat\Behat\Context\Context;
use Webmozart\Assert\Assert;

final class ManagingAnimalsContext implements Context
{
    /** @var IndexPage */
    private $indexPage;

    public function __construct(IndexPage $indexPage)
    {
        $this->indexPage = $indexPage;
    }

    /**
     * @When I want to see all animals
     */
    public function iWantToSeeAllAnimals(): void
    {
        $this->indexPage->open();
    }

    /**
     * @Then I should see :nbAnimals animals in the list
     */
    public function iShouldSeeAnimalsInTheList(int $nbAnimals): void
    {
        Assert::eq($this->indexPage->countItems(), $nbAnimals);
    }

    /**
     * @Then I should see the animal :name in the list
     */
    public function iShouldSeeTheAnimalInTheList(string $name)
    {
        Assert::true($this->indexPage->isSingleResourceOnPage(['name' => $name]));
    }
}
