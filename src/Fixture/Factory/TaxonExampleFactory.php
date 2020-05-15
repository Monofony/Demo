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
use Monofony\Plugin\FixturesPlugin\Fixture\Factory\AbstractExampleFactory;
use Monofony\Plugin\FixturesPlugin\Fixture\Factory\ExampleFactoryInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Taxonomy\Generator\TaxonSlugGeneratorInterface;
use Sylius\Component\Taxonomy\Model\TaxonInterface;
use Sylius\Component\Taxonomy\Repository\TaxonRepositoryInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class TaxonExampleFactory extends AbstractExampleFactory implements ExampleFactoryInterface
{
    /**
     * @var FactoryInterface
     */
    private $taxonFactory;

    /**
     * @var TaxonRepositoryInterface
     */
    private $taxonRepository;

    /**
     * @var \Faker\Generator
     */
    private $faker;

    /**
     * @var TaxonSlugGeneratorInterface
     */
    private $taxonSlugGenerator;

    /**
     * @var OptionsResolver
     */
    private $optionsResolver;

    /**
     * @var string
     */
    private $localeCode;

    public function __construct(
        FactoryInterface $taxonFactory,
        TaxonRepositoryInterface $taxonRepository,
        TaxonSlugGeneratorInterface $taxonSlugGenerator
    ) {
        $this->taxonFactory = $taxonFactory;
        $this->taxonRepository = $taxonRepository;
        $this->taxonSlugGenerator = $taxonSlugGenerator;

        $this->faker = \Faker\Factory::create();
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
        $taxon = $this->taxonRepository->findOneBy(['code' => $options['code']]);

        if (null === $taxon) {
            $taxon = $this->taxonFactory->createNew();
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

            ->setDefault('parent', null)
            ->setAllowedTypes('parent', ['null', 'string', TaxonInterface::class])
            ->setNormalizer('parent', LazyOption::findOneBy($this->taxonRepository, 'code'))

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
    }

    private function getLocales(): iterable
    {
        yield 'fr_FR';
        yield 'en_US';
    }
}
