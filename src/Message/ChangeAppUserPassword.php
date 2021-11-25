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

namespace App\Message;

final class ChangeAppUserPassword implements AppUserIdAwareInterface
{
    public ?int $appUserId = null;

    public function __construct(public ?string $currentPassword = null, public ?string $newPassword = null)
    {
    }

    public function getAppUserId(): ?int
    {
        return $this->appUserId;
    }

    public function setAppUserId(?int $appUserId): void
    {
        $this->appUserId = $appUserId;
    }
}
