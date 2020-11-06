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

namespace App\Tests\Behat\Context\Domain;

use Behat\Behat\Context\Context;
use Doctrine\ORM\EntityManagerInterface;
use Monofony\Bridge\Behat\Service\SharedStorageInterface;
use Monofony\Contracts\Core\Model\Customer\CustomerInterface;
use Monofony\Contracts\Core\Model\User\AppUserInterface;
use Webmozart\Assert\Assert;

final class CustomerContext implements Context
{
    /**
     * @var SharedStorageInterface
     */
    private $sharedStorage;

    /** @var EntityManagerInterface */
    private $manager;

    public function __construct(SharedStorageInterface $sharedStorage, EntityManagerInterface $manager)
    {
        $this->sharedStorage = $sharedStorage;
        $this->manager = $manager;
    }

    /**
     * @Then my email should still be :email
     */
    public function myEmailShouldStill($email): void
    {
        /** @var AppUserInterface $user */
        $user = $this->sharedStorage->get('user');

        $this->manager->refresh($user);

        Assert::eq($user->getCustomer()->getEmail(), $email);
    }

    /**
     * @Then my email should be :email
     */
    public function myEmailShouldBe($email): void
    {
        /** @var AppUserInterface $user */
        $user = $this->sharedStorage->get('user');

        $this->manager->refresh($user);

        Assert::eq($user->getUsername(), $email);
    }
}
