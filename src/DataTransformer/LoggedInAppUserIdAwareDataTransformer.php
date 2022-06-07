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

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Message\AppUserIdAwareInterface;
use Monofony\Contracts\Core\Model\User\AppUserInterface;
use Sylius\Component\User\Model\UserInterface;
use Symfony\Component\Security\Core\Security;

final class LoggedInAppUserIdAwareDataTransformer implements DataTransformerInterface
{
    public function __construct(private Security $security)
    {
    }

    /**
     * @param AppUserIdAwareInterface $object
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public function transform($object, string $to, array $context = []): AppUserIdAwareInterface
    {
        /** @var AppUserInterface|UserInterface $user */
        $user = $this->security->getUser();

        if (!$user instanceof AppUserInterface) {
            return $object;
        }

        $object->setAppUserId($user->getId());

        return $object;
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return is_a($context['input']['class'], AppUserIdAwareInterface::class, true);
    }
}
