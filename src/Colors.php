<?php

/*
 * This file is part of the Monofony demo.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App;

class Colors
{
    public const BEIGE = 'beige';
    public const BROWN = 'brown';
    public const BLACK = 'black';
    public const GREY = 'grey';
    public const GINGER = 'ginger';
    public const LIGHTGREY = 'lightgrey';
    public const ORANGE = 'orange';
    public const WHITE = 'white';

    public const ALL = [
        self::BEIGE,
        self::BROWN,
        self::BLACK,
        self::GREY,
        self::GINGER,
        self::LIGHTGREY,
        self::ORANGE,
        self::WHITE,
    ];

    private function __construct()
    {
    }
}
