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

namespace App;

final class Sexes
{
    public const MALE = 'male';
    public const FEMALE = 'female';

    public const ALL = [
        self::MALE,
        self::FEMALE,
    ];

    private function __construct()
    {
    }
}
