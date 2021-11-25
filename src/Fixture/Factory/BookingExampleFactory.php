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

namespace App\Fixture\Factory;

use App\BookingStates;
use App\Entity\Animal\Pet;
use App\Entity\Booking\Booking;
use App\Entity\Customer\Customer;
use App\Fixture\OptionsResolver\LazyOption;
use App\PetStates;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class BookingExampleFactory extends AbstractExampleFactory
{
    private Generator $faker;

    private OptionsResolver $optionsResolver;

    public function __construct(private EntityManagerInterface $entityManager)
    {
        $this->faker = Factory::create();
        $this->optionsResolver = new OptionsResolver();

        $this->configureOptions($this->optionsResolver);
    }

    public function create(array $options = []): Booking
    {
        $options = $this->optionsResolver->resolve($options);

        $booking = new Booking();
        $booking->setPet($options['pet']);
        $booking->setCustomer($options['customer']);
        $booking->setStatus($options['status']);
        $booking->setCreatedAt($options['createdAt']);
        $booking->setFamilyContactedAt($options['familyContactedAt']);

        if (
            BookingStates::FINISHED !== $booking->getStatus()
            && BookingStates::CANCELED !== $booking->getStatus()
            && BookingStates::REFUSED !== $booking->getStatus()
        ) {
            $booking->getPet()->setStatus(PetStates::BOOKED);
        }

        return $booking;
    }

    protected function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefault('pet', LazyOption::randomOne(
                $this->entityManager->getRepository(Pet::class)
            ))
            ->setDefault('customer', LazyOption::randomOne(
                $this->entityManager->getRepository(Customer::class)
            ))
            ->setNormalizer('customer', LazyOption::findOneBy(
                $this->entityManager->getRepository(Customer::class),
                'email'
            ))
            ->setDefault('status', function (Options $options) {
                return $this->faker->randomElement(BookingStates::ALL);
            })
            ->setDefault('createdAt', function (Options $options) {
                return $this->faker->dateTimeBetween('-2 years');
            })
            ->setDefault('familyContactedAt', function (Options $options) {
                /** @var string $status */
                $status = $options['status'];

                /** @var \DateTime $createdAt */
                $createdAt = $options['createdAt'];
                $familyContactedAt = clone $createdAt;

                $familyContactedAt->add(new \DateInterval('P1D'));

                return ('new' !== $status) ? $familyContactedAt : null;
            })
        ;
    }
}
