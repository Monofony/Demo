<?php

/*
 * This file is part of the Monofony demo.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Fixture\Factory;

use App\Entity\Animal\Animal;
use Monofony\Plugin\FixturesPlugin\Fixture\Factory\AbstractExampleFactory;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnimalExampleFactory extends AbstractExampleFactory
{
    /** @var \Faker\Generator */
    private $faker;

    /** @var OptionsResolver */
    private $optionsResolver;

    /**
     * AnimalExampleFactory constructor.
     */
    public function __construct()
    {
        $this->faker = \Faker\Factory::create();
        $this->optionsResolver = new OptionsResolver();

        $this->configureOptions($this->optionsResolver);
    }

    protected function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefault('name', function (Options $options) {
                return $this->faker->firstName;
            })
            ->setDefault('description', function (Options $options) {
                return $this->faker->text;
            })
        ;
    }

    public function create(array $options = []): Animal
    {
        $options = $this->optionsResolver->resolve($options);

        $animal = new Animal();
        $animal->setName($options['name']);
        $animal->setSlug($options['name']);
        $animal->setDescription($options['description']);

        return $animal;
    }
}
