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

use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Monofony\Component\Core\Model\Customer\CustomerInterface;
use Monofony\Component\Core\Model\User\AppUserInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\User\Canonicalizer\CanonicalizerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class RegisterAppUserHandler implements MessageHandlerInterface
{
    /** @var CanonicalizerInterface */
    protected $canonicalizer;

    /** @var FactoryInterface */
    protected $appUserFactory;

    /** @var FactoryInterface */
    protected $customerFactory;

    /** @var CustomerRepository */
    protected $customerRepository;

    /** @var EntityManagerInterface */
    protected $appUserManager;

    public function __construct(
        CanonicalizerInterface $canonicalizer,
        FactoryInterface $appUserFactory,
        FactoryInterface $customerFactory,
        CustomerRepository $customerRepository,
        EntityManagerInterface $appUserManager
    ) {
        $this->canonicalizer = $canonicalizer;
        $this->appUserFactory = $appUserFactory;
        $this->customerFactory = $customerFactory;
        $this->customerRepository = $customerRepository;
        $this->appUserManager = $appUserManager;
    }

    public function __invoke(RegisterAppUser $command): void
    {
        /** @var AppUserInterface $user */
        $user = $this->appUserFactory->createNew();
        $user->setPlainPassword($command->password);

        $customer = $this->provideCustomer($command->email);
        $customer->setFirstName($command->firstName);
        $customer->setLastName($command->lastName);
        $customer->setEmail($command->email);
        $customer->setPhoneNumber($command->phoneNumber);
        $customer->setUser($user);

        $this->appUserManager->persist($user);
    }

    public function provideCustomer(string $email): CustomerInterface
    {
        $emailCanonical = $this->canonicalizer->canonicalize($email);

        /** @var CustomerInterface|null $customer */
        $customer = $this->customerRepository->findOneBy(['emailCanonical' => $emailCanonical]);

        if ($customer === null) {
            /** @var CustomerInterface $customer */
            $customer = $this->customerFactory->createNew();
        }

        if ($customer->getUser() !== null) {
            throw new \DomainException(sprintf('User with email "%s" is already registered', $emailCanonical));
        }

        return $customer;
    }
}
