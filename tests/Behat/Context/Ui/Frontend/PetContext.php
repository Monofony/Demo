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

use App\Entity\Animal\Pet;
use App\Tests\Behat\Page\Frontend\Animal\IndexPage;
use App\Tests\Behat\Page\Frontend\Animal\ShowPage;
use Behat\Behat\Context\Context;
use Webmozart\Assert\Assert;

final class PetContext implements Context
{
    /** @var IndexPage */
    private $indexPage;

    /** @var ShowPage */
    private $showPage;

    public function __construct(IndexPage $indexPage, ShowPage $showPage)
    {
        $this->indexPage = $indexPage;
        $this->showPage = $showPage;
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

    /**
     * @Then /^I check (this pet)'s details$/
     */
    public function iCheckThisAnimalsDetails(Pet $animal)
    {
        $this->showPage->open(['slug' => $animal->getSlug()]);
    }

    /**
     * @Then I should see the animal name :animalName
     */
    public function iShouldSeeTheAnimalName(string $animalName)
    {
        Assert::same($this->showPage->getName(), $animalName);
    }
}
