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

use App\Colors;
use App\Entity\Animal\Pet;
use App\Tests\Behat\Page\Frontend\Pet\IndexPage;
use App\Tests\Behat\Page\Frontend\Pet\IndexPerTaxonPage;
use App\Tests\Behat\Page\Frontend\Pet\ShowPage;
use Behat\Behat\Context\Context;
use Sylius\Component\Taxonomy\Model\TaxonInterface;
use Webmozart\Assert\Assert;

final class PetContext implements Context
{
    public function __construct(
        private IndexPage $indexPage,
        private IndexPerTaxonPage $indexPerTaxonPage,
        private ShowPage $showPage,
    ) {
    }

    /**
     * @Given I want to browse pets
     */
    public function iWantToBrowsePets(): void
    {
        $this->indexPage->open();
    }

    /**
     * @When /^I browse pets from (taxon "([^"]+)")$/
     */
    public function iBrowsePetsFromTaxon(TaxonInterface $taxon): void
    {
        $this->indexPerTaxonPage->open(['slug' => $taxon->getSlug()]);
    }

    /**
     * @Then /^I check (this pet)'s details$/
     */
    public function iCheckThisAnimalsDetails(Pet $animal): void
    {
        $this->showPage->open(['slug' => $animal->getSlug()]);
    }

    /**
     * @When I only want to see the black pets
     */
    public function iOnlyWantToSeeTheBlackPets(): void
    {
        $this->indexPage->filterByColor(Colors::BLACK);
    }

    /**
     * @Then I only want to see the males
     */
    public function iOnlyWantToSeeTheMales(): void
    {
        $this->indexPage->filterBySex('Male');
    }

    /**
     * @Then I only want to see the small pets
     */
    public function iOnlyWantToSeeTheSmallPets(): void
    {
        $this->indexPage->filterBySize('Small');
    }

    /**
     * @Then I filter from taxon :taxonName
     */
    public function iFilterFromTaxon(string $taxonName): void
    {
        $this->indexPage->filterByTaxon($taxonName);
    }

    /**
     * @Then I should see the pet :petName
     */
    public function iShouldSeeThePet(string $petName): void
    {
        Assert::true($this->indexPage->isPetOnList($petName));
    }

    /**
     * @Then I should not see the pet :petName
     */
    public function iShouldNotSeeThePet(string $petName): void
    {
        Assert::false($this->indexPage->isPetOnList($petName));
    }

    /**
     * @Then I should see the pet name :petName
     */
    public function iShouldSeeTheAnimalName(string $petName): void
    {
        Assert::same($this->showPage->getName(), $petName);
    }
}
