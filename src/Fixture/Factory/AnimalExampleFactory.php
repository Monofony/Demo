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
use phpDocumentor\Reflection\Types\Array_;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Sylius\Component\Taxonomy\Model\TaxonInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnimalExampleFactory extends AbstractExampleFactory
{
    /** @var \Faker\Generator */
    private $faker;

    /** @var FactoryInterface */
    private $animalImageFactory;

    /** @var RepositoryInterface */
    private $taxonRepository;

    /** @var OptionsResolver */
    private $optionsResolver;

    /** @var string */
    private $testsDir;

    public function __construct(
        FactoryInterface $animalImageFactory,
        RepositoryInterface $taxonRepository,
        string $testsDir
    ) {
        $this->animalImageFactory = $animalImageFactory;
        $this->taxonRepository = $taxonRepository;
        $this->testsDir = $testsDir;

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
            ->setDefault('taxon', LazyOption::randomOne($this->taxonRepository))
            ->setDefault('images', function (Options $options): array {
                /** @var TaxonInterface $taxon */
                $taxon = $options['taxon'];

                $directory = $this->testsDir.'/Resources/animals/'.strtolower($taxon->getCode());
                if (!file_exists($directory)) {
                    return [];
                }

                return LazyOption::randomOnesImage($directory, 3)->call($this, $options);
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
        $animal->setSize($options['size']);
        $animal->setSizeUnit($options['sizeUnit']);
        $animal->setMainColor($options['mainColor']);
        $animal->setTaxon($options['taxon']);

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
