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
use App\Entity\Animal\Pet;
use App\Entity\Animal\PetImage;
use App\Fixture\OptionsResolver\LazyOption;
use App\Repository\TaxonRepository;
use App\Sex;
use App\SizeRanges;
use App\SizeUnits;
use Monofony\Plugin\FixturesPlugin\Fixture\Factory\AbstractExampleFactory;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Taxonomy\Model\TaxonInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Webmozart\Assert\Assert;

class PetExampleFactory extends AbstractExampleFactory
{
    /** @var \Faker\Generator */
    private $faker;

    /** @var FactoryInterface */
    private $petImageFactory;

    /** @var TaxonRepository */
    private $taxonRepository;

    /** @var OptionsResolver */
    private $optionsResolver;

    /** @var string */
    private $testsDir;

    public function __construct(
        FactoryInterface $petImageFactory,
        TaxonRepository $taxonRepository,
        string $testsDir
    ) {
        $this->petImageFactory = $petImageFactory;
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
                return $this->faker->paragraphs(3, true);
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
            ->setDefault('sex', function (Options $options) {
                return $this->faker->randomElement(Sex::ALL);
            })
            ->setDefault('size_range', function (Options $options) {
                return $this->faker->randomElement(SizeRanges::ALL);
            })
            ->setDefault('taxon', $this::randomOne($this->taxonRepository))
            ->setDefault('images', function (Options $options): array {
                /** @var TaxonInterface $taxon */
                $taxon = $options['taxon'];

                $closure = $this->randomImages($taxon, $options);

                return $closure->call($this, $options);
            })
        ;
    }

    public function create(array $options = []): Pet
    {
        $options = $this->optionsResolver->resolve($options);

        $animal = new Pet();
        $animal->setName($options['name']);
        $animal->setSlug($options['name']);
        $animal->setDescription($options['description']);
        $animal->setSize($options['size']);
        $animal->setSizeUnit($options['sizeUnit']);
        $animal->setMainColor($options['mainColor']);
        $animal->setSex($options['sex']);
        $animal->setTaxon($options['taxon']);
        $animal->setSizeRange($options['size_range']);

        $this->createImages($animal, $options);

        return $animal;
    }

    private function createImages(Pet $animal, array $options)
    {
        $filesystem = new Filesystem();

        foreach ($options['images'] as $imagePath) {
            $basename = basename($imagePath);
            $filesystem->copy($imagePath, '/tmp/'.$basename);
            $file = new UploadedFile('/tmp/'.$basename, $basename, null, null, true);

            /** @var PetImage $image */
            $image = $this->petImageFactory->createNew();
            $image->setFile($file);

            $animal->addImage($image);
        }
    }

    private static function randomOne(TaxonRepository $repository): \Closure
    {
        return function (Options $options) use ($repository) {
            $objects = $repository->findTaxonsWithoutChildren();

            if ($objects instanceof Collection) {
                $objects = $objects->toArray();
            }

            Assert::notEmpty($objects);

            return $objects[array_rand($objects)];
        };
    }

    private function randomImages(TaxonInterface $taxon, Options $options): \Closure
    {
        $directory = $this->testsDir.'/Resources/pets/'.strtolower($taxon->getSlug());
        if (!is_dir($directory)) {
            if ($taxon->isRoot) {
                return function(): array {
                    return [];
                };
            }

            return $this->randomImages($taxon->getParent(), $options);
        }

        return LazyOption::randomOnesImage($directory, 3);
    }
}