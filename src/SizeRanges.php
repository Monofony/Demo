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

final class SizeRanges
{
    public const SMALL = 'small';
    public const MEDIUM = 'medium';
    public const TALL = 'tall';

    public const ALL = [
        self::SMALL,
        self::MEDIUM,
        self::TALL,
    ];

    private function __construct()
    {
    }

    public static function choices(): array
    {
        return [
            'app.ui.small' => self::SMALL,
            'app.ui.medium' => self::MEDIUM,
            'app.ui.tall' => self::TALL,
        ];
    }
}
