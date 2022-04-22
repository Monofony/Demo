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

class Colors
{
    public const BEIGE = 'beige';
    public const BROWN = 'brown';
    public const BLACK = 'black';
    public const GREY = 'grey';
    public const GINGER = 'ginger';
    public const LIGHTGREY = 'lightgrey';
    public const ORANGE = 'orange';
    public const ALL = [
        self::BEIGE,
        self::BROWN,
        self::BLACK,
        self::LIGHTGREY,
        self::GREY,
        self::GINGER,
        self::ORANGE,
        self::WHITE,
    ];

    public const WHITE = 'white';

    private function __construct()
    {
    }

    public static function choices(): array
    {
        return [
            'app.ui.beige' => self::BEIGE,
            'app.ui.orange' => self::ORANGE,
            'app.ui.ginger' => self::GINGER,
            'app.ui.brown' => self::BROWN,
            'app.ui.white' => self::WHITE,
            'app.ui.lightgrey' => self::LIGHTGREY,
            'app.ui.grey' => self::GREY,
            'app.ui.black' => self::BLACK,
        ];
    }
}
