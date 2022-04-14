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

final class BookingStates
{
    public const NEW = 'new';
    public const FAMILY_CONTACTED = 'family_contacted';
    public const VISIT_SCHEDULED = 'visit_scheduled';
    public const CANCELED = 'canceled';
    public const FINISHED = 'finished';
    public const REFUSED = 'refused';

    public const ALL = [
        self::NEW,
        self::FAMILY_CONTACTED,
        self::VISIT_SCHEDULED,
        self::CANCELED,
        self::FINISHED,
        self::REFUSED,
    ];

    private function __construct()
    {
    }

    public static function choices(): array
    {
        return [
            'sylius.ui.new' => self::NEW,
            'sylius.ui.family_contacted' => self::FAMILY_CONTACTED,
            'sylius.ui.visit_scheduled' => self::VISIT_SCHEDULED,
            'sylius.ui.canceled' => self::CANCELED,
            'sylius.ui.finished' => self::FINISHED,
            'sylius.ui.refused' => self::REFUSED,
        ];
    }
}
