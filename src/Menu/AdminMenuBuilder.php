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
        $this->addCustomerSubMenu($menu);
        $this->addConfigurationSubMenu($menu);

        return $menu;
    }

    private function addAnimalSubMenu(ItemInterface $menu): ItemInterface
    {
        $customer = $menu
            ->addChild('animal')
            ->setLabel('sylius.ui.animal')
        ;

        $customer->addChild('backend_animal', ['route' => 'app_backend_animal_index'])
            ->setLabel('sylius.ui.animals')
            ->setLabelAttribute('icon', 'cat');

        return $customer;
    }

    private function addCustomerSubMenu(ItemInterface $menu): ItemInterface
    {
        $animal = $menu
            ->addChild('customer')
            ->setLabel('sylius.ui.customer')
        ;

        $animal->addChild('backend_customer', ['route' => 'sylius_backend_customer_index'])
            ->setLabel('sylius.ui.customers')
            ->setLabelAttribute('icon', 'users');

        return $animal;
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
