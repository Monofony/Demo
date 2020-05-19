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

use App\Colors;
use App\Entity\Animal\Animal;
use App\Entity\Animal\AnimalImage;
use App\Fixture\OptionsResolver\LazyOption;
use App\SizeUnits;
use Monofony\Plugin\FixturesPlugin\Fixture\Factory\AbstractExampleFactory;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnimalExampleFactory extends AbstractExampleFactory
{
    /** @var \Faker\Generator */
    private $faker;

    /** @var FactoryInterface */
    private $animalImageFactory;

    /** @var OptionsResolver */
    private $optionsResolver;

    /**
     * AnimalExampleFactory constructor.
     */
    public function __construct(FactoryInterface $animalImageFactory)
    {
        $this->animalImageFactory = $animalImageFactory;
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
            ->setDefault('size', function (Options $options) {
                return $this->faker->randomFloat(2, 1.00, 10.00);
            })
            ->setDefault('sizeUnit', function (Options $options) {
                return $this->faker->randomElement(SizeUnits::ALL);
            })
            ->setDefault('mainColor', function (Options $options) {
                return $this->faker->randomElement(Colors::ALL);
            })
            ->setDefault('images', LazyOption::randomOnesImage(
                __DIR__.'/../../../tests/Resources', 1
            ))
        ;
    }

    public function create(array $options = []): Animal
    {
        $options = $this->optionsResolver->resolve($options);

        $animal = new Animal();
        $animal->setName($options['name']);
        $animal->setSlug($options['name']);
        $animal->setDescription($options['description']);
        $animal->setSize($options['size']);
        $animal->setSizeUnit($options['sizeUnit']);
        $animal->setMainColor($options['mainColor']);

        $this->createImages($animal, $options);

        return $animal;
    }

    private function createImages(Animal $animal, array $options)
    {
        $filesystem = new Filesystem();

        foreach ($options['images'] as $imagePath) {
            $basename = basename($imagePath);
            $filesystem->copy($imagePath, '/tmp/'.$basename);
            $file = new UploadedFile('/tmp/'.$basename, $basename, null, null, true);

            /** @var AnimalImage $image */
            $image = $this->animalImageFactory->createNew();
            $image->setFile($file);

            $animal->addImage($image);
        }
    }
}
