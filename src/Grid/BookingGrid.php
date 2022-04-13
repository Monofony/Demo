<?php

namespace App\Grid;

use App\Entity\Booking\Booking;
use Sylius\Bundle\GridBundle\Builder\ActionGroup\ItemActionGroup;
use Sylius\Bundle\GridBundle\Builder\Field\DateTimeField;
use Sylius\Bundle\GridBundle\Builder\Field\StringField;
use Sylius\Bundle\GridBundle\Builder\Filter\StringFilter;
use Sylius\Bundle\GridBundle\Builder\GridBuilderInterface;
use Sylius\Bundle\GridBundle\Grid\ResourceAwareGridInterface;
use Sylius\Bundle\GridBundle\Grid\AbstractGrid;

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
            ->addFilter(
                StringFilter::create('search', ['pet.name', 'booker.email'])
                    ->setLabel('sylius.ui.search')
            )
            ->addField(
                StringField::create('pet')
                    ->setLabel('app.ui.pet')
                    ->setPath('pet.name')
                    ->setSortable(true, 'pet.name')
            )
            ->addField(
                StringField::create('booker')
                    ->setLabel('sylius.ui.customer')
                    ->setPath('booker.email')
                    ->setSortable(true, 'booker.email')
            )
            ->addField(
                DateTimeField::create('createdAt', 'Y-m-d')
                    ->setLabel('sylius.ui.registration_date')
                    ->setSortable(true)
            )
            ->addActionGroup(
                ItemActionGroup::create(
                    // ShowAction::create(),
                )
            )
        ;
    }

    public function getResourceClass(): string
    {
        return Booking::class;
    }
}
