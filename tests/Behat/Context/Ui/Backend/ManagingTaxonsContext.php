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

namespace App\Tests\Behat\Context\Ui\Backend;

use App\Entity\Taxonomy\Taxon;
use App\Tests\Behat\Page\Backend\Taxon\CreatePage;
use App\Tests\Behat\Page\Backend\Taxon\UpdatePage;
use Behat\Behat\Context\Context;
use Webmozart\Assert\Assert;

final class ManagingTaxonsContext implements Context
{
    /** @var CreatePage */
    private $createPage;

    /** @var UpdatePage */
    private $updatePage;

    public function __construct(CreatePage $createPage, UpdatePage $updatePage)
    {
        $this->createPage = $createPage;
        $this->updatePage = $updatePage;
    }

    /**
     * @Given I want to create a new taxon
     * @Given I want to see all taxons in the list
     */
    public function iWantToCreateANewTaxon()
    {
        $this->createPage->open();
    }

    /**
     * @Given I specify its code as :code
     */
    public function iSpecifyItsCodeAs(string $code)
    {
        $this->createPage->specifyCode($code);
    }

    /**
     * @Given I specify its name as :name
     */
    public function iSpecifyItsNameAs(string $name)
    {
        $this->createPage->specifyName($name);
    }

    /**
     * @Given I specify its slug as :slug
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
     * @When /^I want to edit (this taxon)$/
     */
    public function iWantToEditThisTaxon(Taxon $taxon)
    {
        $this->updatePage->open(['id' => $taxon->getId()]);
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
     * @Then the taxon :taxon should appear in the registry
     */
    public function theTaxonShouldAppearInTheList(Taxon $taxon)
    {
        $this->updatePage->open(['id' => $taxon->getId()]);
        Assert::true($this->updatePage->hasResourceValues(['name' => $taxon->getName()]));
    }

    /**
     * @Then this taxon :element should be :value
     */
    public function thisTaxonElementShouldBe($element, $value)
    {
        Assert::true($this->updatePage->hasResourceValues([$element => $value]));
    }

    /**
     * @Then I should see :number taxons on the list
     */
    public function iShouldSeeTaxonsOnTheList(int $number)
    {
        Assert::same($this->createPage->countTaxons(), (int) $number);
    }

    /**
     * @Then I should see the taxon named :name in the list
     */
    public function iShouldSeeTheTaxonNamedInTheList(string $name)
    {
        Assert::same($this->createPage->countTaxonsByName($name), 1);
    }

    /**
     * @When I move up :name taxon
     */
    public function iMoveUpTaxon(string $name)
    {
        $this->createPage->moveUpTaxon($name);
    }

    /**
     * @When I move down :name taxon
     */
    public function iMoveDownTaxon(string $name)
    {
        $this->createPage->moveDownTaxon($name);
    }

    /**
     * @Then the first taxon on the list should be :name
     */
    public function theFirstTaxonOnTheListShouldBe(string $name)
    {
        Assert::same($this->createPage->getFirstTaxonOnTheList(), $name);
    }
}
