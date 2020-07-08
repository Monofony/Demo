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

use Sylius\Component\User\Canonicalizer\CanonicalizerInterface;
use Sylius\Component\User\Repository\UserRepositoryInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Webmozart\Assert\Assert;

final class UniqueAppUserEmailValidator extends ConstraintValidator
{
    /** @var CanonicalizerInterface */
    private $canonicalizer;

    /** @var UserRepositoryInterface */
    private $appUserRepository;

    public function __construct(CanonicalizerInterface $canonicalizer, UserRepositoryInterface $appUserRepository)
    {
        $this->canonicalizer = $canonicalizer;
        $this->appUserRepository = $appUserRepository;
    }

    public function validate($value, Constraint $constraint): void
    {
        if ($value === null) {
            return;
        }

        /** @var UniqueAppUserEmail $constraint */
        Assert::isInstanceOf($constraint, UniqueAppUserEmail::class);

        $emailCanonical = $this->canonicalizer->canonicalize($value);
        $appUser = $this->appUserRepository->findOneByEmail($emailCanonical);

        if ($appUser === null) {
            return;
        }

        $this->context->addViolation($constraint->message);
    }
}
