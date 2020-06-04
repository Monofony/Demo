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
use Webmozart\Assert\Assert;

final class PetContext implements Context
{
    /**
     * @Then the pet :pet should have one image
     * @Then the pet :pet should have one :amountOfImages images
     */
    public function thePetShouldHaveAnImage(Pet $pet, int $amountOfImages = 1)
    {
        Assert::eq(count($pet->getImages()), $amountOfImages);
    }
}
