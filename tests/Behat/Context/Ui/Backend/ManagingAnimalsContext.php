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

use App\Entity\Animal\Animal;
use App\Tests\Behat\Page\Backend\Animal\CreatePage;
use App\Tests\Behat\Page\Backend\Animal\IndexPage;
use App\Tests\Behat\Page\Backend\Animal\UpdatePage;
use Behat\Behat\Context\Context;
use Webmozart\Assert\Assert;

final class ManagingAnimalsContext implements Context
{
    /** @var CreatePage */
    private $createPage;

    /** @var IndexPage */
    private $indexPage;

    /** @var UpdatePage */
    private $updatePage;

    public function __construct(
        CreatePage $createPage,
        IndexPage $indexPage,
        UpdatePage $updatePage
    ) {
        $this->createPage = $createPage;
        $this->indexPage = $indexPage;
        $this->updatePage = $updatePage;
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
     * @When I do not specify any name
     */
    public function iSpecifyItsNameAs(string $name = null)
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
     * @When I (try to )add it
     */
    public function iAddIt()
    {
        $this->createPage->create();
    }

    /**
     * @Then the animal :name should appear in the list
     */
    public function theAnimalShouldAppearInTheStore(string $name)
    {
        $this->indexPage->open();

        Assert::true($this->indexPage->isSingleResourceOnPage(['name' => $name]));
    }

    /**
     * @Then the animal with :slug should appear in the list
     */
    public function theAnimalWithSlugShouldAppearInTheStore(string $slug)
    {
        $this->indexPage->open();

        Assert::true($this->indexPage->isSingleResourceOnPage(['slug' => $slug]));
    }

    /**
     * @When /^I want to edit (this animal)$/
     */
    public function iWantToEditThisAnimal(Animal $animal): void
    {
        $this->updatePage->open(['id' => $animal->getId()]);
    }

    /**
     * @When I change its name to :name
     */
    public function iChangeItsNameTo(string $name)
    {
        $this->updatePage->changeName($name);
    }

    /**
     * @When I change its slug to :slug
     */
    public function iChangeItsSlugTo(string $slug)
    {
        $this->updatePage->changeSlug($slug);
    }

    /**
     * @When I save my changes
     */
    public function iSaveMyChanges()
    {
        $this->updatePage->saveChanges();
    }

    /**
     * @Then I should be notified that the name is required
     */
    public function iShouldBeNotifiedThatTheNameIsRequired()
    {
        Assert::true($this->createPage->checkValidationName(
            'name',
            'This value should not be blank.')
        );
    }

    /**
     * @Then this animal should not be added
     */
    public function thisAnimalShouldNotBeAdded()
    {
        $this->indexPage->open();
        Assert::eq($this->indexPage->countItems(), 0);
    }
}
