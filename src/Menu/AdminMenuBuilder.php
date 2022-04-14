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

namespace App\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Monofony\Component\Admin\Menu\AdminMenuBuilderInterface;

final class AdminMenuBuilder implements AdminMenuBuilderInterface
{
    public function __construct(private FactoryInterface $factory)
    {
    }

    public function createMenu(array $options): ItemInterface
    {
        $menu = $this->factory->createItem('root');

        $this->addPetSubMenu($menu);
        $this->addBookingSubMenu($menu);
        $this->addCustomerSubMenu($menu);
        $this->addConfigurationSubMenu($menu);

        return $menu;
    }

    private function addPetSubMenu(ItemInterface $menu): void
    {
        $pet = $menu
            ->addChild('pet')
            ->setLabel('app.ui.pet')
        ;

        $pet->addChild('backend_pet', ['route' => 'app_backend_pet_index'])
            ->setLabel('app.ui.pets')
            ->setLabelAttribute('icon', 'cat');

        $pet->addChild('backend_taxon', ['route' => 'sylius_backend_taxon_create'])
            ->setLabel('sylius.ui.taxons')
            ->setLabelAttribute('icon', 'fax');
    }

    private function addBookingSubMenu(ItemInterface $menu): void
    {
        $booking = $menu
            ->addChild('booking')
            ->setLabel('app.ui.booking')
        ;

        $booking->addChild('backend_booking', ['route' => 'app_backend_booking_index'])
            ->setLabel('app.ui.bookings')
            ->setLabelAttribute('icon', 'fax');
    }

    private function addCustomerSubMenu(ItemInterface $menu): void
    {
        $customer = $menu
            ->addChild('customer')
            ->setLabel('sylius.ui.customer')
        ;

        $customer->addChild('backend_customer', ['route' => 'sylius_backend_customer_index'])
            ->setLabel('sylius.ui.customers')
            ->setLabelAttribute('icon', 'users');
    }

    private function addConfigurationSubMenu(ItemInterface $menu): void
    {
        $configuration = $menu
            ->addChild('configuration')
            ->setLabel('sylius.ui.configuration')
        ;

        $configuration->addChild('backend_admin_user', ['route' => 'sylius_backend_admin_user_index'])
            ->setLabel('sylius.ui.admin_users')
            ->setLabelAttribute('icon', 'lock');
    }
}
