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

namespace App\Grid\Frontend;

use App\Colors;
use App\Entity\Animal\Pet;
use App\Grid\Builder\Filter\FrontendSelectFilter;
use App\Sexes;
use App\SizeRanges;
use Sylius\Bundle\GridBundle\Builder\Field\StringField;
use Sylius\Bundle\GridBundle\Builder\Filter\Filter;
use Sylius\Bundle\GridBundle\Builder\GridBuilderInterface;
use Sylius\Bundle\GridBundle\Grid\AbstractGrid;
use Sylius\Bundle\GridBundle\Grid\ResourceAwareGridInterface;
use Sylius\Component\Taxonomy\Repository\TaxonRepositoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;

final class PetGrid extends AbstractGrid implements ResourceAwareGridInterface
{
    public function __construct(
        private string $locale,
        private RequestStack $requestStack,
        private TaxonRepositoryInterface $taxonRepository,
    ) {
    }

    public static function getName(): string
    {
        return 'app_frontend_pet';
    }

    public function buildGrid(GridBuilderInterface $gridBuilder): void
    {
        $slug = $this->requestStack->getCurrentRequest()?->get('slug');
        $taxon = null !== $slug ? $this->taxonRepository->findOneBySlug($slug, $this->locale) : null;

        $gridBuilder
            ->setRepositoryMethod('createListForFrontQueryBuilder', ['locale' => $this->locale, 'taxon' => $taxon])
            ->addOrderBy('name', 'asc')
            ->setLimits([12])
            ->addField(
                StringField::create('name')
                    ->setSortable(true),
            )
            ->addFilter(
                Filter::create('taxon', 'taxon_filter')
                    ->setLabel('app.ui.pet'),
            )
            ->addFilter(
                FrontendSelectFilter::create(name: 'sex', choices: Sexes::choices(), multiple: true, expanded: true)
                    ->setLabel('app.ui.sex'),
            )
            ->addFilter(
                FrontendSelectFilter::create(name: 'mainColor', choices: Colors::choices(), multiple: true, expanded: true)
                    ->setLabel('app.ui.main_color'),
            )
            ->addFilter(
                FrontendSelectFilter::create(name: 'sizeRange', choices: SizeRanges::choices(), multiple: true, field: 'taxon.sizeRange', expanded: true)
                    ->setLabel('app.ui.size'),
            )
        ;
    }

    public function getResourceClass(): string
    {
        return Pet::class;
    }
}
