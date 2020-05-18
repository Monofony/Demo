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

use App\Entity\Animal\Animal;
use Behat\Behat\Context\Context;
use Monofony\Bundle\CoreBundle\Tests\Behat\Service\SharedStorageInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Webmozart\Assert\Assert;

final class AnimalContext implements Context
{
    /** @var RepositoryInterface */
    private $animalRepository;

    /** @var SharedStorageInterface */
    private $sharedStorage;

    public function __construct(
        RepositoryInterface $animalRepository,
        SharedStorageInterface $sharedStorage
    ) {
        $this->animalRepository = $animalRepository;
        $this->sharedStorage = $sharedStorage;
    }

    /**
     * @Transform :animal
     * @Transform /^animal "([^"]+)"$/
     */
    public function getAnimalByName(string $animalName): Animal
    {
        $animal = $this->animalRepository->findOneBy(['name' => $animalName]);
        Assert::notNull(
            $animal,
            sprintf('Animal with name "%s" does not exist', $animalName)
        );

        return $animal;
    }


}
