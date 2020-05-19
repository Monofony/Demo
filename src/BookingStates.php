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

final class BookingStates
{
    public const FINISHED = 'finished';
    public const NEW = 'new';
    public const VALIDATED = 'validated';

    public const ALL = [
        self::FINISHED,
        self::NEW,
        self::VALIDATED,
    ];

    private function __construct()
    {
    }
}
