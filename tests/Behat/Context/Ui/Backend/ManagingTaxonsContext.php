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

use App\Tests\Behat\Page\Backend\Taxon\CreatePage;
use App\Tests\Behat\Page\Backend\Taxon\IndexPage;
use Behat\Behat\Context\Context;

final class ManagingTaxonsContext implements Context
{
    /** @var CreatePage */
    private $createPage;

    public function __construct(CreatePage $createPage)
    {
        $this->createPage = $createPage;
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
     * @Then this taxonomy with name :name should appear in the website
     */
    public function thisTaxonomyWithNameShouldAppearInTheWebsite(string $name)
    {
        // todo
    }
}
