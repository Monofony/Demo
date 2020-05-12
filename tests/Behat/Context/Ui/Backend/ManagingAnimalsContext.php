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

use App\Tests\Behat\Page\Backend\Animal\CreatePage;
use App\Tests\Behat\Page\Backend\Animal\IndexPage;
use Behat\Behat\Context\Context;
use Webmozart\Assert\Assert;

final class ManagingAnimalsContext implements Context
{
    /** @var CreatePage */
    private $createPage;

    /** @var IndexPage */
    private $indexPage;


    public function __construct(CreatePage $createPage, IndexPage $indexPage)
    {
        $this->createPage = $createPage;
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

    /**
     * @Given I want to create a new animal
     */
    public function iWantToCreateANewAnimal()
    {
        $this->createPage->open();
    }

    /**
     * @When I specify its name as :name
     */
    public function iSpecifyItsNameAs(string $name)
    {
        $this->createPage->specifyName($name);
    }

    /**
     * @When I specify its slug as :slug
     */
    public function iSpecifyItsSlugAs(string $slug)
    {
        $this->createPage->specifySlug($slug);
    }

    /**
     * @When I add it
     */
    public function iAddIt()
    {
        $this->createPage->create();
    }

    /**
     * @Then the animal :name should appear in the store
     */
    public function theAnimalShouldAppearInTheStore(string $name)
    {
        $this->indexPage->open();

        Assert::true($this->indexPage->isSingleResourceOnPage(['name' => $name]));
    }

}
