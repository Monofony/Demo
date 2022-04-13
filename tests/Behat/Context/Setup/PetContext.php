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

namespace App\Tests\Behat\Context\Setup;

use App\Factory\PetFactory;
use Behat\Behat\Context\Context;
use Monofony\Bridge\Behat\Service\SharedStorageInterface;

final class PetContext implements Context
{
    public function __construct(private SharedStorageInterface $sharedStorage)
    {
    }

    /**
     * @Given there is (also) a pet with name :name
     */
    public function thereIsAPetWithName(string $name): void
    {
        $this->createWithOptions(['name' => $name]);
    }

    private function createWithOptions(array $options): void
    {
        $pet = PetFactory::createOne($options)->object();

        $this->sharedStorage->set('pet', $pet);
    }
}
