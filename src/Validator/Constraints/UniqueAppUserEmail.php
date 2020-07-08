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

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

final class UniqueAppUserEmail extends Constraint
{
    /** @var string */
    public $message = 'app.user.email.unique';

    public function validatedBy(): string
    {
        return 'app.validator.unique_app_user_email';
    }
}
