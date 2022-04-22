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

namespace App\Grid\Builder\Filter;

use Sylius\Bundle\GridBundle\Builder\Filter\Filter;
use Sylius\Bundle\GridBundle\Builder\Filter\FilterInterface;

final class FrontendSelectFilter
{
    public static function create(string $name, array $choices, ?bool $multiple = null, ?string $field = null, ?bool $expanded = true): FilterInterface
    {
        $filter = Filter::create($name, 'frontend_select');

        $filter->setFormOptions(['choices' => $choices]);

        if (null !== $field) {
            $filter->setOptions(['field' => $field]);
        }

        if (null !== $multiple) {
            $filter->addFormOption('multiple', $multiple);
        }

        if (null !== $expanded) {
            $filter->addFormOption('expanded', $expanded);
        }

        return $filter;
    }
}
