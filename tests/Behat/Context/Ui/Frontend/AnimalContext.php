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

namespace App\Tests\Behat\Context\Ui\Frontend;

use App\Tests\Behat\Page\Frontend\Animal\IndexPage;
use Behat\Behat\Context\Context;
use Webmozart\Assert\Assert;

final class AnimalContext implements Context
{
    /** @var IndexPage */
    private $indexPage;

    public function __construct(IndexPage $indexPage)
    {
        $this->indexPage = $indexPage;
    }

    /**
     * @Given I want to browse animals
     */
    public function iWantToBrowseAnimals()
    {
        $this->indexPage->open();
    }

    /**
     * @Then I should see the animal :name
     */
    public function iShouldSeeTheAnimal(string $name)
    {
        Assert::true($this->indexPage->isAnimalOnList($name));
    }
}
