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
use App\Tests\Behat\Page\Backend\Taxon\IndexPage;
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
}
