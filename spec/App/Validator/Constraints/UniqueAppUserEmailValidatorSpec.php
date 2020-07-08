<?php

namespace spec\App\Validator\Constraints;

use App\Validator\Constraints\UniqueAppUserEmail;
use Monofony\Component\Core\Model\User\AppUserInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sylius\Component\User\Canonicalizer\CanonicalizerInterface;
use Sylius\Component\User\Repository\UserRepositoryInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidatorInterface;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class UniqueAppUserEmailValidatorSpec extends ObjectBehavior
{
    function let(
        CanonicalizerInterface $canonicalizer,
        UserRepositoryInterface $appUserRepository,
        ExecutionContextInterface $executionContext
    ) : void {
        $this->beConstructedWith($canonicalizer, $appUserRepository);
        $this->initialize($executionContext);
    }

    function it_is_a_constraint_validator(): void
    {
        $this->shouldImplement(ConstraintValidatorInterface::class);
    }

    function it_is_does_nothing_if_value_is_null(ExecutionContextInterface $executionContext): void
    {
        $executionContext->addViolation(Argument::cetera())->shouldNotBeCalled();

        $this->validate(null, new UniqueAppUserEmail());
    }

    function it_throws_an_exception_if_constraint_is_not_of_expeted_type(): void
    {
        $this->shouldThrow(\InvalidArgumentException::class)->during('validate', ['', new class() extends Constraint{
        }]);
    }

    function it_does_not_add_violation_if_a_user_with_given_email_is_not_found(
        CanonicalizerInterface $canonicalizer,
        UserRepositoryInterface $appUserRepository,
        ExecutionContextInterface $executionContext
    ): void {
        $canonicalizer->canonicalize('eMaIl@example.com')->willReturn('email@example.com');
        $appUserRepository->findOneByEmail('email@example.com')->willReturn(null);

        $executionContext->addViolation(Argument::cetera())->shouldNotBeCalled();

        $this->validate('eMaIl@example.com', new UniqueAppUserEmail());
    }

    function it_adds_violation_if_a_user_with_given_email_is_found(
        CanonicalizerInterface $canonicalizer,
        UserRepositoryInterface $appUserRepository,
        ExecutionContextInterface $executionContext,
        AppUserInterface $appUser
    ): void {
        $canonicalizer->canonicalize('eMaIl@example.com')->willReturn('email@example.com');
        $appUserRepository->findOneByEmail('email@example.com')->willReturn($appUser);

        $executionContext->addViolation(Argument::cetera())->shouldBeCalled();

        $this->validate('eMaIl@example.com', new UniqueAppUserEmail());
    }
}
