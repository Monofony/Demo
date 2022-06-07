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

namespace App\MessageHandler;

use App\Message\ChangeAppUserPassword;
use Doctrine\ORM\EntityManagerInterface;
use Monofony\Contracts\Core\Model\User\AppUserInterface;
use Sylius\Component\User\Repository\UserRepositoryInterface;
use Sylius\Component\User\Security\PasswordUpdaterInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Webmozart\Assert\Assert;

final class ChangeAppUserPasswordHandler implements MessageHandlerInterface
{
    public function __construct(
        private PasswordUpdaterInterface $passwordUpdater,
        private UserRepositoryInterface $appUserRepository,
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function __invoke(ChangeAppUserPassword $message): void
    {
        /** @var AppUserInterface|null $user */
        $user = $this->appUserRepository->find($message->getAppUserId());

        Assert::notNull($user);

        $user->setPlainPassword($message->newPassword);

        $this->passwordUpdater->updatePassword($user);

        $this->entityManager->flush();
    }
}
