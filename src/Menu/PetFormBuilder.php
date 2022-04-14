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

final class PetFormBuilder
{
    public function __construct(private FactoryInterface $factory)
    {
    }

    public function createMenu(array $options = []): ItemInterface
    {
        $menu = $this->factory->createItem('root');

        $menu
            ->addChild('details')
            ->setAttribute('template', 'backend/pet/tab/_details.html.twig')
            ->setLabel('sylius.ui.details')
            ->setCurrent(true)
        ;

        $menu
            ->addChild('taxonomy')
            ->setAttribute('template', 'backend/pet/tab/_taxonomy.html.twig')
            ->setLabel('sylius.ui.taxonomy')
        ;

        $menu
            ->addChild('media')
            ->setAttribute('template', 'backend/pet/tab/_media.html.twig')
            ->setLabel('sylius.ui.media')
        ;

        return $menu;
    }
}
