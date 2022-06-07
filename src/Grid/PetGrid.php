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

namespace App\Grid;

use App\Entity\Animal\Pet;
use Sylius\Bundle\GridBundle\Builder\Action\CreateAction;
use Sylius\Bundle\GridBundle\Builder\Action\DeleteAction;
use Sylius\Bundle\GridBundle\Builder\Action\ShowAction;
use Sylius\Bundle\GridBundle\Builder\Action\UpdateAction;
use Sylius\Bundle\GridBundle\Builder\ActionGroup\BulkActionGroup;
use Sylius\Bundle\GridBundle\Builder\ActionGroup\ItemActionGroup;
use Sylius\Bundle\GridBundle\Builder\ActionGroup\MainActionGroup;
use Sylius\Bundle\GridBundle\Builder\Field\StringField;
use Sylius\Bundle\GridBundle\Builder\Field\TwigField;
use Sylius\Bundle\GridBundle\Builder\Filter\StringFilter;
use Sylius\Bundle\GridBundle\Builder\GridBuilderInterface;
use Sylius\Bundle\GridBundle\Grid\AbstractGrid;
use Sylius\Bundle\GridBundle\Grid\ResourceAwareGridInterface;

final class PetGrid extends AbstractGrid implements ResourceAwareGridInterface
{
    public function __construct(private string $locale)
    {
    }

    public static function getName(): string
    {
        return 'app_pet';
    }

    public function buildGrid(GridBuilderInterface $gridBuilder): void
    {
        $gridBuilder
            ->setRepositoryMethod('createListQueryBuilder', ['$taxonId', $this->locale])
            ->addOrderBy('name', 'asc')
            ->setLimits([10, 25, 50])
            ->addFilter(
                StringFilter::create('search', ['name', 'slug'])
                    ->setLabel('sylius.ui.search'),
            )
            ->addField(
                TwigField::create('image', 'backend/pet/grid/field/image.html.twig')
                    ->setLabel('sylius.ui.image')
                    ->setPath('.'),
            )
            ->addField(
                StringField::create('name')
                    ->setLabel('Name')
                    ->setSortable(true),
            )
            ->addField(
                StringField::create('taxon')
                    ->setLabel('app.ui.taxon')
                    ->setSortable(true, 'translation.name')
                    ->setPath('taxon.translation.name'),
            )
            ->addActionGroup(
                MainActionGroup::create(
                    CreateAction::create(),
                ),
            )
            ->addActionGroup(
                ItemActionGroup::create(
                    // ShowAction::create(),
                    UpdateAction::create(),
                    DeleteAction::create(),
                ),
            )
            ->addActionGroup(
                BulkActionGroup::create(
                    DeleteAction::create(),
                ),
            )
        ;
    }

    public function getResourceClass(): string
    {
        return Pet::class;
    }
}
