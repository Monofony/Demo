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

namespace App\Tests\Behat\Context\Transform;

use App\Entity\Animal\Pet;
use Behat\Behat\Context\Context;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Webmozart\Assert\Assert;

final class PetContext implements Context
{
    /** @var RepositoryInterface */
    private $animalRepository;

    public function __construct(RepositoryInterface $animalRepository)
    {
        $this->animalRepository = $animalRepository;
    }

    /**
     * @Transform :pet
     * @Transform /^pet "([^"]+)"$/
     */
    public function getPetByName(string $petName): Pet
    {
        /** @var Pet $pet */
        $pet = $this->animalRepository->findOneBy(['name' => $petName]);
        Assert::notNull(
            $pet,
            sprintf('Pet with name "%s" does not exist', $petName)
        );

        return $pet;
    }
}
