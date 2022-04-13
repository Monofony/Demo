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

namespace App\Factory;

use App\Entity\Animal\Pet;
use App\Repository\PetRepository;
use App\Sexes;
use App\SizeUnits;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Pet>
 *
 * @method static    Pet|Proxy createOne(array $attributes = [])
 * @method static    Pet[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static    Pet|Proxy find(object|array|mixed $criteria)
 * @method static    Pet|Proxy findOrCreate(array $attributes)
 * @method static    Pet|Proxy first(string $sortedField = 'id')
 * @method static    Pet|Proxy last(string $sortedField = 'id')
 * @method static    Pet|Proxy random(array $attributes = [])
 * @method static    Pet|Proxy randomOrCreate(array $attributes = [])
 * @method static    Pet[]|Proxy[] all()
 * @method static    Pet[]|Proxy[] findBy(array $attributes)
 * @method static    Pet[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static    Pet[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static    PetRepository|RepositoryProxy repository()
 * @method Pet|Proxy create(array|callable $attributes = [])
 */
final class PetFactory extends ModelFactory
{
    protected function getDefaults(): array
    {
        return [
            'name' => null,
            'taxon' => TaxonFactory::randomOrCreate(),
            'description' => self::faker()->paragraphs(3, true),
            'size' => self::faker()->randomFloat(2, 1, 10),
            'size_unit' => self::faker()->randomElement(SizeUnits::ALL),
            'sex' => self::faker()->randomElement(Sexes::ALL),
        ];
    }

    protected function initialize(): self
    {
        return $this
            ->beforeInstantiate(function (array $attributes): array {
                if (null === $attributes['name']) {
                    $attributes['name'] = Sexes::FEMALE === $attributes['sex'] ?
                        self::faker()->firstNameFemale() : self::faker()->firstNameMale()
                    ;
                }

                return $attributes;
            });
    }

    protected static function getClass(): string
    {
        return Pet::class;
    }
}
