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

namespace App\Tests\Behat\Context\Transform;

use App\Entity\Animal\Pet;
use Behat\Behat\Context\Context;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Webmozart\Assert\Assert;

final class PetContext implements Context
{
    public function __construct(private RepositoryInterface $petRepository)
    {
    }

    /**
     * @Transform :pet
     * @Transform /^pet "([^"]+)"$/
     */
    public function getPetByName(string $petName): Pet
    {
        /** @var Pet|null $pet */
        $pet = $this->petRepository->findOneBy(['name' => $petName]);
        Assert::notNull(
            $pet,
            sprintf('Pet with name "%s" does not exist', $petName),
        );

        return $pet;
    }
}
