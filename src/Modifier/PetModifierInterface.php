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

namespace App\Modifier;

use App\Entity\Animal\Pet;

interface PetModifierInterface
{
    public function createBooking(Pet $pet): void;

    public function enablePet(Pet $pet): void;

    public function disablePet(Pet $pet): void;
}
