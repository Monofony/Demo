<?php

namespace spec\App\Command;

use App\Command\RegisterAppUser;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Monofony\Component\Core\Model\Customer\CustomerInterface;
use Monofony\Component\Core\Model\User\AppUserInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\User\Canonicalizer\CanonicalizerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class RegisterAppUserHandlerSpec extends ObjectBehavior
{
    function let(
        CanonicalizerInterface $canonicalizer,
        FactoryInterface $appUserFactory,
        FactoryInterface $customerFactory,
        CustomerRepository $customerRepository,
        EntityManagerInterface $appUserManager
    ) : void {
        $this->beConstructedWith(
            $canonicalizer,
            $appUserFactory,
            $customerFactory,
            $customerRepository,
            $appUserManager
        );
    }

    function it_is_a_message_handler()
    {
        $this->shouldImplement(MessageHandlerInterface::class);
    }

    function it_creates_a_customer_and_user_with_given_data(
        CanonicalizerInterface $canonicalizer,
        FactoryInterface $appUserFactory,
        FactoryInterface $customerFactory,
        CustomerRepository $customerRepository,
        EntityManagerInterface $appUserManager,
        AppUserInterface $appUser,
        CustomerInterface $customer
    ): void {
        $canonicalizer->canonicalize('WILL.SMITH@example.com')->willReturn('will.smith@example.com');
        $customerRepository->findOneBy(['emailCanonical' => 'will.smith@example.com'])->willReturn(null);

        $appUserFactory->createNew()->willReturn($appUser);
        $customerFactory->createNew()->willReturn($customer);

        $customer->getUser()->willReturn(null);

        $appUser->setPlainPassword('iamrobot')->shouldBeCalled();

        $customer->setFirstName('Will')->shouldBeCalled();
        $customer->setLastName('Smith')->shouldBeCalled();
        $customer->setEmail('WILL.SMITH@example.com')->shouldBeCalled();
        $customer->setPhoneNumber('+13104322400')->shouldBeCalled();
        $customer->setUser($appUser)->shouldBeCalled();

        $appUserManager->persist($appUser)->shouldBeCalled();

        $this(new RegisterAppUser('Will', 'Smith', 'WILL.SMITH@example.com', 'iamrobot', '+13104322400'));
    }

    function it_creates_only_a_user_if_customer_without_user_already_exists(
        CanonicalizerInterface $canonicalizer,
        FactoryInterface $appUserFactory,
        FactoryInterface $customerFactory,
        CustomerRepository $customerRepository,
        EntityManagerInterface $appUserManager,
        AppUserInterface $appUser,
        CustomerInterface $customer
    ): void {
        $canonicalizer->canonicalize('WILL.SMITH@example.com')->willReturn('will.smith@example.com');
        $customerRepository->findOneBy(['emailCanonical' => 'will.smith@example.com'])->willReturn($customer);

        $appUserFactory->createNew()->willReturn($appUser);
        $customerFactory->createNew()->shouldNotBeCalled();

        $customer->getUser()->willReturn(null);

        $appUser->setPlainPassword('iamrobot')->shouldBeCalled();

        $customer->setFirstName('Will')->shouldBeCalled();
        $customer->setLastName('Smith')->shouldBeCalled();
        $customer->setEmail('WILL.SMITH@example.com')->shouldBeCalled();
        $customer->setPhoneNumber('+13104322400')->shouldBeCalled();
        $customer->setUser($appUser)->shouldBeCalled();

        $appUserManager->persist($appUser)->shouldBeCalled();

        $this(new RegisterAppUser('Will', 'Smith', 'WILL.SMITH@example.com', 'iamrobot', '+13104322400'));
    }
}
