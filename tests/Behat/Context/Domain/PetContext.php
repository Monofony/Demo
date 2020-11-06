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

namespace App\Tests\Behat\Context\Domain;

use App\Entity\Animal\Pet;
use Behat\Behat\Context\Context;
use Doctrine\ORM\EntityManagerInterface;
use Webmozart\Assert\Assert;

final class PetContext implements Context
{
    /** @var EntityManagerInterface */
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @Then the pet :pet should have one image
     * @Then the pet :pet should have one :amountOfImages images
     */
    public function thePetShouldHaveAnImage(Pet $pet, int $amountOfImages = 1)
    {
        Assert::eq(count($pet->getImages()), $amountOfImages);
    }

    /**
     * @Given /^(it|this pet) should be bookable$/
     */
    public function thisPetShouldBeBookable(Pet $animal)
    {
        $this->manager->refresh($animal);
        Assert::eq($animal->getStatus(), 'bookable');
    }
}
