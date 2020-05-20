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
     * @When I save my changes
     */
    public function iSaveMyChanges()
    {
        $this->updatePage->saveChanges();
    }

    /**
     * @Then this animal should not be added
     */
    public function thisAnimalShouldNotBeAdded()
    {
        $this->indexPage->open();
        Assert::eq($this->indexPage->countItems(), 0);
    }

    /**
     * @When I specify its size as :size
     */
    public function iSpecifyItsSizeAs(float $size)
    {
        $this->createPage->specifySize($size);
    }

    /**
     * @When I do not specify any size unit
     */
    public function iDoNotSpecifyAnySizeUnit()
    {
        // Intentionally left blank.
    }

    /**
     * @Then I should be notified that the :element is required
     */
    public function iShouldBeNotifiedThatTheElementIsRequired(string $element)
    {
        Assert::true($this->createPage->checkValidationMessageFor(
            $element,
            'This value should not be blank.')
        );
    }

    /**
     * @When I specify its size unit as :sizeUnit
     */
    public function iSpecifyItsSizeunitAs(string $sizeUnit)
    {
        $this->createPage->specifySizeUnit($sizeUnit);
    }

    /**
     * @When I attach the :path image
     */
    public function iAttachTheImage($path)
    {
        $this->createPage->clickTabIfItsNotActive('media');
        $this->createPage->attachImage($path);
    }

    /**
     * @When I delete animal with name :name
     */
    public function iDeleteAnimalWithName(string $name)
    {
        $this->indexPage->deleteResourceOnPage(['name' => $name]);
    }

    /**
     * @Then there should not be :name animal anymore
     */
    public function thereShouldNotBeAnimalAnymore(string $name)
    {
        Assert::false($this->indexPage->isSingleResourceOnPage(['name' => $name]));
    }
}
