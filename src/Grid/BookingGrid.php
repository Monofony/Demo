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

use App\BookingStates;
use App\Entity\Booking\Booking;
use Sylius\Bundle\GridBundle\Builder\ActionGroup\ItemActionGroup;
use Sylius\Bundle\GridBundle\Builder\Field\DateTimeField;
use Sylius\Bundle\GridBundle\Builder\Field\StringField;
use Sylius\Bundle\GridBundle\Builder\Field\TwigField;
use Sylius\Bundle\GridBundle\Builder\Filter\SelectFilter;
use Sylius\Bundle\GridBundle\Builder\Filter\StringFilter;
use Sylius\Bundle\GridBundle\Builder\GridBuilderInterface;
use Sylius\Bundle\GridBundle\Grid\AbstractGrid;
use Sylius\Bundle\GridBundle\Grid\ResourceAwareGridInterface;

final class BookingGrid extends AbstractGrid implements ResourceAwareGridInterface
{
    public static function getName(): string
    {
        return 'app_booking';
    }

    public function buildGrid(GridBuilderInterface $gridBuilder): void
    {
        $gridBuilder
            ->addOrderBy('createdAt', 'desc')
            ->setLimits([10, 25, 50])
            ->addFilter(
                StringFilter::create('search', ['pet.name', 'booker.email'])
                    ->setLabel('sylius.ui.search'),
            )
            ->addFilter(
                SelectFilter::create('status', BookingStates::choices())
                    ->setLabel('sylius.ui.status'),
            )
            ->addField(
                StringField::create('pet')
                    ->setLabel('app.ui.pet')
                    ->setPath('pet.name')
                    ->setSortable(true, 'pet.name'),
            )
            ->addField(
                StringField::create('booker')
                    ->setLabel('sylius.ui.customer')
                    ->setPath('booker.email')
                    ->setSortable(true, 'booker.email'),
            )
            ->addField(
                TwigField::create('status', '@SyliusUi/Grid/Field/state.html.twig')
                    ->setLabel('sylius.ui.state')
                    ->setOption('vars', ['labels' => 'backend/booking/label/state']),
            )
            ->addField(
                DateTimeField::create('createdAt', 'Y-m-d')
                    ->setLabel('sylius.ui.registration_date')
                    ->setSortable(true),
            )
            ->addActionGroup(
                ItemActionGroup::create(
                    // ShowAction::create(),
                ),
            )
        ;
    }

    public function getResourceClass(): string
    {
        return Booking::class;
    }
}
