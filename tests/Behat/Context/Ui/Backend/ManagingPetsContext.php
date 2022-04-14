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

use App\Entity\Animal\Pet;
use App\Tests\Behat\Page\Backend\Pet\CreatePage;
use App\Tests\Behat\Page\Backend\Pet\IndexPage;
use App\Tests\Behat\Page\Backend\Pet\UpdatePage;
use Behat\Behat\Context\Context;
use Webmozart\Assert\Assert;

final class ManagingPetsContext implements Context
{
    public function __construct(
        private IndexPage $indexPage,
        private CreatePage $createPage,
        private UpdatePage $updatePage,
    ) {
    }

    /**
     * @When I want to browse all pets
     * @Given I am browsing pets
     */
    public function iWantToBrowseAllPets(): void
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
     * @When I delete pet with name :name
     */
    public function iDeletePetWithName(string $name): void
    {
        $this->indexPage->deleteResourceOnPage(['name' => $name]);
    }

    /**
     * @When I specify its name as :name
     * @When I do not specify any name
     */
    public function iSpecifyItsNameAs(?string $name = null): void
    {
        $this->createPage->nameIt($name ?? '');
    }

    /**
     * @When I choose :taxonName as its taxon
     * @When I do not specify any taxon
     */
    public function iChooseAsItsTaxon(?string $taxonName = null): void
    {
        if (null === $taxonName) {
            return;
        }

        $this->createPage->chooseTaxon($taxonName);
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
        $this->updatePage->nameIt($name);
    }

    /**
     * @When I (try to) add it
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

    /**
     * @Then the pet :name should appear in the list
     */
    public function thePetShouldAppearInTheList(string $name): void
    {
        $this->indexPage->open();

        Assert::true($this->indexPage->isSingleResourceOnPage(['name' => $name]));
    }

    /**
     * @Then there should not be :name pet anymore
     */
    public function thereShouldNotBePetAnymore(string $name): void
    {
        $this->indexPage->open();

        Assert::false($this->indexPage->isSingleResourceOnPage(['name' => $name]));
    }

    /**
     * @Then this pet should not be added
     */
    public function thisPetShouldNotBeAdded(): void
    {
        Assert::eq($this->indexPage->countItems(), 0);
    }

    /**
     * @Then I should be notified that the :element is required
     */
    public function iShouldBeNotifiedThatTheElementIsRequired(string $element): void
    {
        Assert::same($this->createPage->getValidationMessage($element), 'This value should not be blank.');
    }

    /**
     * @Then the pet :pet should have one image
     * @Then the pet :pet should have one :amountOfImages images
     */
    public function thePetShouldHaveAnImage(Pet $pet, int $amountOfImages = 1): void
    {
        Assert::eq(count($pet->getImages()), $amountOfImages);
    }
}
