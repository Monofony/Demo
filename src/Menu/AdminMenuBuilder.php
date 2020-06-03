<?php

/*
 * This file is part of the Monofony demo.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Monofony\Bundle\AdminBundle\Menu\AdminMenuBuilderInterface;

final class AdminMenuBuilder implements AdminMenuBuilderInterface
{
    /** @var FactoryInterface */
    private $factory;

    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    /**
     * {@inheritdoc}
     */
    public function createMenu(array $options): ItemInterface
    {
        $menu = $this->factory->createItem('root');

        $this->addAnimalSubMenu($menu);
        $this->addBookingSubMenu($menu);
        $this->addCustomerSubMenu($menu);
        $this->addConfigurationSubMenu($menu);

        return $menu;
    }

    private function addAnimalSubMenu(ItemInterface $menu): ItemInterface
    {
        $animal = $menu
            ->addChild('animal')
            ->setLabel('app.ui.animal')
        ;

        $animal->addChild('backend_animal', ['route' => 'app_backend_animal_index'])
            ->setLabel('app.ui.animals')
            ->setLabelAttribute('icon', 'cat');

        $animal->addChild('backend_taxon', ['route' => 'sylius_backend_taxon_create'])
            ->setLabel('sylius.ui.taxons')
            ->setLabelAttribute('icon', 'fax');

        return $animal;
    }

    private function addBookingSubMenu(ItemInterface $menu): ItemInterface
    {
        $booking = $menu
            ->addChild('booking')
            ->setLabel('app.ui.booking')
        ;

        $booking->addChild('backend_booking', ['route' => 'app_backend_booking_index'])
            ->setLabel('app.ui.bookings')
            ->setLabelAttribute('icon', 'fax');

        return $booking;
    }

    private function addCustomerSubMenu(ItemInterface $menu): ItemInterface
    {
        $customer = $menu
            ->addChild('customer')
            ->setLabel('sylius.ui.customer')
        ;

        $customer->addChild('backend_customer', ['route' => 'sylius_backend_customer_index'])
            ->setLabel('sylius.ui.customers')
            ->setLabelAttribute('icon', 'users');

        return $customer;
    }

    private function addConfigurationSubMenu(ItemInterface $menu): ItemInterface
    {
        $configuration = $menu
            ->addChild('configuration')
            ->setLabel('sylius.ui.configuration')
        ;

        $configuration->addChild('backend_admin_user', ['route' => 'sylius_backend_admin_user_index'])
            ->setLabel('sylius.ui.admin_users')
            ->setLabelAttribute('icon', 'lock');

        return $configuration;
    }
}
