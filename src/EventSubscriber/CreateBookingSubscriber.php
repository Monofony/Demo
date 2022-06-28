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

namespace App\EventSubscriber;

use App\Entity\Animal\Pet;
use App\Modifier\PetModifierInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Workflow\Event\Event;
use Webmozart\Assert\Assert;

class CreateBookingSubscriber implements EventSubscriberInterface
{
    public function __construct(private PetModifierInterface $petModifier)
    {
    }

    public function onPetCompleteBooking(Event $event): void
    {
        /** @var Pet $pet */
        $pet = $event->getSubject();
        Assert::isInstanceOf($pet, Pet::class);

        $this->petModifier->createBooking($pet);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'workflow.pet_booking.completed.book' => 'onPetCompleteBooking',
        ];
    }
}
