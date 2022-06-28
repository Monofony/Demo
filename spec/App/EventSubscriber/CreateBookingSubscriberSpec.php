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

namespace spec\App\EventSubscriber;

use App\Entity\Animal\Pet;
use App\EventSubscriber\CreateBookingSubscriber;
use App\Modifier\PetModifierInterface;
use PhpSpec\ObjectBehavior;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Workflow\Event\Event;

class CreateBookingSubscriberSpec extends ObjectBehavior
{
    function let(PetModifierInterface $petModifier): void
    {
        $this->beConstructedWith($petModifier);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(CreateBookingSubscriber::class);
    }

    public function it_is_a_subscriber(): void
    {
        $this->shouldImplement(EventSubscriberInterface::class);
    }

    public function it_subscribes_to_events(): void
    {
        $this::getSubscribedEvents()->shouldReturn([
            'workflow.pet_booking.completed.book' => 'onPetCompleteBooking',
        ]);
    }

    public function it_creates_booking(
        Event $event,
        Pet $pet,
        PetModifierInterface $petModifier,
    ): void {
        $event->getSubject()->willReturn($pet);

        $petModifier->createBooking($pet)->shouldBeCalled();

        $this->onPetCompleteBooking($event);
    }
}
