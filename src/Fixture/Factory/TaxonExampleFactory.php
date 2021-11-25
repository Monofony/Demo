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

namespace App\Fixture\Factory;

use App\Entity\Taxonomy\Taxon;
use App\Fixture\OptionsResolver\LazyOption;
use App\Formatter\StringInflector;
use App\SizeRanges;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use Faker\Generator;
use Sylius\Component\Taxonomy\Generator\TaxonSlugGeneratorInterface;
use Sylius\Component\Taxonomy\Model\TaxonInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class TaxonExampleFactory extends AbstractExampleFactory implements ExampleFactoryInterface
{
    private Generator $faker;

    private OptionsResolver $optionsResolver;

    public function __construct(private EntityManagerInterface $entityManager, private TaxonSlugGeneratorInterface $taxonSlugGenerator)
    {
        $this->faker = Factory::create();
        $this->optionsResolver = new OptionsResolver();

        $this->configureOptions($this->optionsResolver);
    }

    public function create(array $options = [])
    {
        $options = $this->optionsResolver->resolve($options);

        return $this->createTaxon($options, $options['parent']);
    }

    public function createTaxon(array $options = [], ?TaxonInterface $parentTaxon = null): Taxon
    {
        $options = $this->optionsResolver->resolve($options);

        /** @var Taxon $taxon */
        $taxon = $this->entityManager->getRepository(Taxon::class)->findOneBy(['code' => $options['code']]);

        if (null === $taxon) {
            $taxon = new Taxon();
        }

        $taxon->setCode($options['code']);

        if (null !== $parentTaxon) {
            $taxon->setParent($parentTaxon);
        }

        // add translation for each defined locales
        foreach ($this->getLocales() as $localeCode) {
            $this->createTranslation($taxon, $localeCode, $options);
        }

        // create or replace with custom translations
        foreach ($options['translations'] as $localeCode => $translationOptions) {
            $this->createTranslation($taxon, $localeCode, $translationOptions);
        }

        foreach ($options['children'] as $childOptions) {
            $this->createTaxon($childOptions, $taxon);
        }

        return $taxon;
    }

    protected function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefault('name', function (Options $options) {
                return $this->faker->words(3, true);
            })

            ->setDefault('code', function (Options $options) {
                return StringInflector::nameToCode($options['name']);
            })

            ->setDefault('slug', null)

            ->setDefault('description', function (Options $options) {
                return $this->faker->paragraph;
            })
            ->setDefault('size_range', function (Options $options) {
                return $this->faker->randomElement(SizeRanges::ALL);
            })
            ->setDefault('parent', null)
            ->setAllowedTypes('parent', ['null', 'string', TaxonInterface::class])
            ->setNormalizer('parent', LazyOption::findOneBy(
                $this->entityManager->getRepository(Taxon::class),
                'code'
            ))

            ->setDefault('children', [])
            ->setAllowedTypes('children', 'array')

            ->setDefault('translations', [])
            ->setAllowedTypes('translations', ['array'])
            ->setDefault('children', [])
            ->setAllowedTypes('children', ['array']);
    }

    private function createTranslation(Taxon $taxon, string $localeCode, array $options = []): void
    {
        $options = $this->optionsResolver->resolve($options);

        $taxon->setCurrentLocale($localeCode);
        $taxon->setFallbackLocale($localeCode);

        $taxon->setName($options['name']);
        $taxon->setDescription($options['description']);
        $taxon->setSlug($options['slug'] ?: $this->taxonSlugGenerator->generate($taxon, $localeCode));

        $taxon->setSizeRange($options['size_range']);
    }

    private function getLocales(): iterable
    {
        yield 'fr_FR';
        yield 'en_US';
    }
}
