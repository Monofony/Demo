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

final class RegisterAppUser
{
    public function __construct(public ?string $email = null, public ?string $password = null, public ?string $firstName = null, public ?string $lastName = null, public ?string $phoneNumber = null)
    {
    }
}
