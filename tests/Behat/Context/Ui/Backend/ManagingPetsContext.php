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

use App\Entity\Animal\Pet;
use App\Tests\Behat\Page\Backend\Pet\CreatePage;
use App\Tests\Behat\Page\Backend\Pet\IndexPage;
use App\Tests\Behat\Page\Backend\Pet\UpdatePage;
use Behat\Behat\Context\Context;
use Webmozart\Assert\Assert;

final class ManagingPetsContext implements Context
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
     * @When I want to see all pets
     */
    public function iWantToSeeAllPets(): void
    {
        $this->indexPage->open();
    }

    /**
     * @Given I want to create a new pet
     */
    public function iWantToCreateANewPet(): void
    {
        $this->createPage->open();
    }

    /**
     * @When /^I want to edit (this pet)$/
     */
    public function iWantToEditThisPet(Pet $pet): void
    {
        $this->updatePage->open(['id' => $pet->getId()]);
    }

    /**
     * @When I specify its name as :name
     * @When I do not specify any name
     */
    public function iSpecifyItsNameAs(string $name = null): void
    {
        $this->createPage->specifyName($name);
    }

    /**
     * @When I specify its size as :size
     */
    public function iSpecifyItsSizeAs(float $size): void
    {
        $this->createPage->specifySize($size);
    }

    /**
     * @When I specify its size unit as :sizeUnit
     * @When I do not specify any size unit
     */
    public function iSpecifyItsSizeunitAs(string $sizeUnit = null): void
    {
        if (null === $sizeUnit) {
            return;
        }

        $this->createPage->specifySizeUnit($sizeUnit);
    }

    /**
     * @When I specify its taxon as :name
     */
    public function iSpecifyItsTaxonAs(string $name): void
    {
        $this->createPage->specifyTaxon($name);
    }

    /**
     * @When I attach the :path image
     */
    public function iAttachTheImage(string $path): void
    {
        $this->createPage->attachImage($path);
    }

    /**
     * @When I change its name to :name
     */
    public function iChangeItsNameTo(string $name): void
    {
        $this->updatePage->changeName($name);
    }

    /**
     * @When I (try to )add it
     */
    public function iAddIt(): void
    {
        $this->createPage->create();
    }

    /**
     * @When I save my changes
     */
    public function iSaveMyChanges(): void
    {
        $this->updatePage->saveChanges();
    }

    /**
     * @When I delete pet with name :name
     */
    public function iDeletePetWithName(string $name): void
    {
        $this->indexPage->deleteResourceOnPage(['name' => $name]);
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
     * @Then the pet :name should appear in the list
     */
    public function iShouldSeeThePetInTheList(string $name): void
    {
        $this->indexPage->open();

        Assert::true($this->indexPage->isSingleResourceOnPage(['name' => $name]));
    }

    /**
     * @Then this pet should not be added
     */
    public function thisAnimalShouldNotBeAdded(): void
    {
        $this->indexPage->open();
        Assert::eq($this->indexPage->countItems(), 0);
    }

    /**
     * @Then there should not be :name pet anymore
     */
    public function thereShouldNotBePetAnymore(string $name): void
    {
        Assert::false($this->indexPage->isSingleResourceOnPage(['name' => $name]));
    }

    /**
     * @Then I should be notified that the :element is required
     */
    public function iShouldBeNotifiedThatTheElementIsRequired(string $element): void
    {
        Assert::true($this->createPage->checkValidationMessageFor(
            $element,
            'This value should not be blank.')
        );
    }

    /**
     * @When I filter them by :taxonName taxon
     */
    public function iFilterThemByTaxon(string $taxonName)
    {
        $this->indexPage->filterByTaxon($taxonName);
    }

    /**
     * @Then I should not see any animal with name :name
     */
    public function iShouldNotSeeAnyAnimalWithName(string $name)
    {
        Assert::false($this->indexPage->isSingleResourceOnPage(["name" => $name]));
    }
}
