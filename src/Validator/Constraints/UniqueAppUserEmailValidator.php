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

namespace App\Validator\Constraints;

use Sylius\Component\User\Canonicalizer\CanonicalizerInterface;
use Sylius\Component\User\Repository\UserRepositoryInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Webmozart\Assert\Assert;

final class UniqueAppUserEmailValidator extends ConstraintValidator
{
    public function __construct(private CanonicalizerInterface $canonicalizer, private UserRepositoryInterface $appUserRepository)
    {
    }

    public function validate($value, Constraint $constraint): void
    {
        if (null === $value) {
            return;
        }

        /* @var UniqueAppUserEmail $constraint */
        Assert::isInstanceOf($constraint, UniqueAppUserEmail::class);

        $emailCanonical = $this->canonicalizer->canonicalize($value);
        $shopUser = $this->appUserRepository->findOneByEmail($emailCanonical);

        if (null === $shopUser) {
            return;
        }

        $this->context->addViolation($constraint->message);
    }
}
