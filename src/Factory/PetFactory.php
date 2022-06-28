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

use App\Colors;
use App\Entity\Animal\Pet;
use App\Entity\Animal\PetImage;
use App\Entity\Taxonomy\Taxon;
use App\PetStates;
use App\Repository\PetRepository;
use App\Sexes;
use App\SizeUnits;
use Sylius\Component\Taxonomy\Model\TaxonInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Pet>
 *
 * @method static Pet|Proxy createOne(array $attributes = [])
 * @method static Pet[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Pet|Proxy find(object|array|mixed $criteria)
 * @method static Pet|Proxy findOrCreate(array $attributes)
 * @method static Pet|Proxy first(string $sortedField = 'id')
 * @method static Pet|Proxy last(string $sortedField = 'id')
 * @method static Pet|Proxy random(array $attributes = [])
 * @method static Pet|Proxy randomOrCreate(array $attributes = [])
 * @method static Pet[]|Proxy[] all()
 * @method static Pet[]|Proxy[] findBy(array $attributes)
 * @method static Pet[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Pet[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static PetRepository|RepositoryProxy repository()
 * @method Pet|Proxy create(array|callable $attributes = [])
 */
final class PetFactory extends ModelFactory
{
    public function __construct(private string $testsDir)
    {
        parent::__construct();
    }

    public function withName(string $name): self
    {
        return $this->addState(['name' => $name]);
    }

    public function withMainColor(string $mainColor): self
    {
        return $this->addState(['main_color' => $mainColor]);
    }

    public function withTaxon(Proxy|Taxon|string $taxon): self
    {
        return $this->addState(['taxon' => $taxon]);
    }

    protected function getDefaults(): array
    {
        return [
            'name' => null,
            'taxon' => TaxonFactory::randomOrCreate(),
            'description' => self::faker()->paragraphs(3, true),
            'size' => self::faker()->randomFloat(2, 1, 10),
            'size_unit' => self::faker()->randomElement(SizeUnits::ALL),
            'sex' => self::faker()->randomElement(Sexes::ALL),
            'images' => null,
            'main_color' => null,
            'status' => self::faker()->randomElement(PetStates::ALL),
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

                if (\is_string($attributes['taxon'])) {
                    $attributes['taxon'] = TaxonFactory::find(['code' => $attributes['taxon']]);
                }

                if (null === $attributes['images']) {
                    $attributes['images'] = $this->randomImages($attributes['taxon']);
                }

                if (null === $attributes['main_color']) {
                    $firstImage = $attributes['images'][0] ?? null;

                    if (null !== $firstImage) {
                        $attributes['main_color'] = self::getColor($firstImage);
                    }
                }

                return $attributes;
            })
            ->instantiateWith(function (array $attributes): Pet {
                $pet = new Pet();
                $pet->setName($attributes['name']);
                $pet->setTaxon($attributes['taxon']);
                $pet->setDescription($attributes['description']);
                $pet->setSize($attributes['size']);
                $pet->setSizeUnit($attributes['size_unit']);
                $pet->setSex($attributes['sex']);
                $pet->setMainColor($attributes['main_color']);
                $pet->setStatus($attributes['status']);

                $this->createImages($pet, $attributes);

                if (in_array($pet->getStatus(), [PetStates::BOOKED, PetStates::BOOKABLE], true)) {
                    $pet->setEnabled(true);
                }

                return $pet;
            })
        ;
    }

    protected static function getClass(): string
    {
        return Pet::class;
    }

    private function createImages(Pet $animal, array $options)
    {
        $filesystem = new Filesystem();

        foreach ($options['images'] as $imagePath) {
            $basename = basename($imagePath);
            $filesystem->copy($imagePath, '/tmp/' . $basename);
            $file = new UploadedFile('/tmp/' . $basename, $basename, null, null, true);

            $image = new PetImage();
            $image->setFile($file);

            $animal->addImage($image);
        }
    }

    private function randomImages(Proxy|TaxonInterface $taxon): array
    {
        $directory = $this->testsDir . '/Resources/pets/' . strtolower((string) $taxon->getSlug());
        if (!is_dir($directory)) {
            if ($taxon->isRoot()) {
                return [];
            }

            return $this->randomImages($taxon->getParent());
        }

        return self::randomOnesImage($directory, 3);
    }

    public static function randomOnesImage(string $directory, int $amount): array
    {
        $finder = new Finder();
        $files = $finder->files()->in($directory);
        $images = [];

        foreach ($files as $file) {
            $images[] = $file->getPathname();
        }

        $selectedImages = [];
        for (; $amount > 0 && count($images) > 0; --$amount) {
            $randomKey = array_rand($images);

            $selectedImages[] = $images[$randomKey];

            unset($images[$randomKey]);
        }

        return $selectedImages;
    }

    private static function getColor(string $fileName): ?string
    {
        foreach (Colors::ALL as $color) {
            if (str_contains($fileName, '-' . $color)) {
                return $color;
            }
        }

        return null;
    }
}
