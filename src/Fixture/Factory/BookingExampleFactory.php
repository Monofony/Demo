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
use App\Entity\Booking\Booking;
use App\Fixture\OptionsResolver\LazyOption;
use App\Repository\CustomerRepository;
use Monofony\Plugin\FixturesPlugin\Fixture\Factory\AbstractExampleFactory;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class BookingExampleFactory extends AbstractExampleFactory
{
    /** @var FactoryInterface */
    private $bookingFactory;

    /** @var RepositoryInterface */
    private $petRepository;

    /** @var CustomerRepository */
    private $customerRepository;

    /** @var \Faker\Generator */
    private $faker;

    /** @var OptionsResolver */
    private $optionsResolver;

    public function __construct(FactoryInterface $bookingFactory, RepositoryInterface $petRepository, CustomerRepository $customerRepository)
    {
        $this->bookingFactory = $bookingFactory;
        $this->petRepository = $petRepository;
        $this->customerRepository = $customerRepository;

        $this->faker = \Faker\Factory::create();
        $this->optionsResolver = new OptionsResolver();

        $this->configureOptions($this->optionsResolver);
    }

    protected function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefault('pet', LazyOption::randomOne($this->petRepository))
            ->setDefault('customer', LazyOption::randomOne($this->customerRepository))
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
                $familyContactedAt = clone ($createdAt);

                $familyContactedAt->add(new \DateInterval('P1D'));

                return ('new' !== $status) ? $familyContactedAt : null;
            })
        ;
    }

    public function create(array $options = []): Booking
    {
        $options = $this->optionsResolver->resolve($options);

        /** @var Booking $booking */
        $booking = $this->bookingFactory->createNew();
        $booking->setPet($options['pet']);
        $booking->setCustomer($options['customer']);
        $booking->setStatus($options['status']);
        $booking->setCreatedAt($options['createdAt']);
        $booking->setFamilyContactedAt($options['familyContactedAt']);

        return $booking;
    }
}
