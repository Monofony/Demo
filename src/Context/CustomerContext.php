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

namespace App\Context;

use Monofony\Contracts\Core\Model\User\AppUserInterface;
use Sylius\Component\Customer\Context\CustomerContextInterface;
use Sylius\Component\Customer\Model\CustomerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class CustomerContext implements CustomerContextInterface
{
    public function __construct(private TokenStorageInterface $tokenStorage, private AuthorizationCheckerInterface $authorizationChecker)
    {
    }

    /**
     * Gets customer based on currently logged user.
     */
    public function getCustomer(): ?CustomerInterface
    {
        if (null === $token = $this->tokenStorage->getToken()) {
            return null;
        }

        $user = $token->getUser();
        if (
            $user instanceof AppUserInterface &&
            $this->authorizationChecker->isGranted('IS_AUTHENTICATED_REMEMBERED')
        ) {
            return $user->getCustomer();
        }

        return null;
    }
}
