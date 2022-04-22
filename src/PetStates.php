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

final class PetStates
{
    public const NEW = 'new';
    public const BOOKABLE = 'bookable';
    public const BOOKED = 'booked';
    public const ADOPTED = 'adopted';

    public const ALL = [
        self::NEW,
        self::BOOKABLE,
        self::BOOKED,
        self::ADOPTED,
    ];

    private function __construct()
    {
    }
}
