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

use Symfony\Component\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

final class ResetPasswordRequest
{
    /**
     * @var string|null
     *
     * @Assert\NotBlank(message="sylius.user.email.not_blank")
     *
     * @Serializer\Groups({"customer:write"})
     */
    public $email;

    public function __construct(string $email = null)
    {
        $this->email = $email;
    }
}
