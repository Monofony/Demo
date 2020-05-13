<?php

/*
 * This file is part of the Monofony demo.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App;

class SizeUnits
{

    public const METER = 'meter';
    public const CENTIMETER = 'centimeter';
    public const MILLIMETER = 'millimeter';

    public const ALL = [
        self::MILLIMETER,
        self::CENTIMETER,
        self::METER,
    ];

    private function __construct()
    {
    }
}
