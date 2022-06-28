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
use Monofony\Contracts\Front\Menu\AccountMenuBuilderInterface;
use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final class AccountMenuBuilder implements AccountMenuBuilderInterface
{
    public const EVENT_NAME = 'sylius.menu.app.account';

    public function __construct(private FactoryInterface $factory, private EventDispatcherInterface $eventDispatcher)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function createMenu(array $options): ItemInterface
    {
        $menu = $this->factory->createItem('root');
        $menu->setLabel('sylius.ui.my_account');

        $menu
            ->addChild('dashboard', ['route' => 'sylius_frontend_account_dashboard'])
            ->setLabel('app.ui.bookings')
            ->setLabelAttribute('icon', 'fas fa-scroll')
        ;

        $menu
            ->addChild('personal_information', ['route' => 'sylius_frontend_account_profile_update'])
            ->setLabel('sylius.ui.personal_information')
            ->setLabelAttribute('icon', 'fas fa-user')
        ;

        $menu
            ->addChild('change_password', ['route' => 'sylius_frontend_account_change_password'])
            ->setLabel('sylius.ui.change_password')
            ->setLabelAttribute('icon', 'fas fa-lock')
        ;

        $this->eventDispatcher->dispatch(new MenuBuilderEvent($this->factory, $menu), self::EVENT_NAME);

        return $menu;
    }
}
