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

namespace App\Message;

interface AppUserIdAwareInterface
{
    public function getAppUserId(): ?int;

    public function setAppUserId(?int $appUserId): void;
}
