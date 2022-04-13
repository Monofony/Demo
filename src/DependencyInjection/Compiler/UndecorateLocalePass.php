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

namespace App\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class UndecorateLocalePass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $contextLocaleCompositeDefinition = $container->getDefinition('sylius.context.locale.composite');
        $contextLocaleCompositeDefinition->setDecoratedService(null);
    }
}
