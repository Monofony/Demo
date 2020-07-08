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

namespace App\Command;

use ApiPlatform\Core\Annotation\ApiProperty;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @psalm-immutable
 */
final class RegisterAppUser
{
    /**
     * @var string
     *
     * @Assert\NotBlank()
     */
    public $firstName;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     */
    public $lastName;

    /**
     * @var string
     *
     * @ApiProperty(identifier=true)
     *
     * @Assert\NotBlank()
     * @Assert\Length(
     *     max = 254
     * )
     * @Assert\Email()
     */
    public $email;

    /**
     * @var string `
     *
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min = 4,
     *     max = 254
     * )
     */
    public $password;

    /** @var string|null */
    public $phoneNumber;

    public function __construct(
        string $firstName,
        string $lastName,
        string $email,
        string $password,
        ?string $phoneNumber = null
    ) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
        $this->phoneNumber = $phoneNumber;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
