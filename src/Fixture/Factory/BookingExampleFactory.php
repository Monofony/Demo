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
    private $animalRepository;

    /** @var CustomerRepository */
    private $customerRepository;

    /** @var \Faker\Generator */
    private $faker;

    /** @var OptionsResolver */
    private $optionsResolver;

    public function __construct(FactoryInterface $bookingFactory, RepositoryInterface $animalRepository, CustomerRepository $customerRepository)
    {
        $this->bookingFactory = $bookingFactory;
        $this->animalRepository = $animalRepository;
        $this->customerRepository = $customerRepository;

        $this->faker = \Faker\Factory::create();
        $this->optionsResolver = new OptionsResolver();

        $this->configureOptions($this->optionsResolver);
    }

    protected function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefault('animal', LazyOption::randomOne($this->animalRepository))
            ->setDefault('customer', LazyOption::randomOne($this->customerRepository))
            ->setDefault('status', function (Options $options) {
                return $this->faker->randomElement(BookingStates::ALL);
            })
            ->setDefault('createdAt', function (Options $options) {
                return $this->faker->dateTime;
            })
            ->setDefault('validateAt', function (Options $options) {
                return $this->faker->dateTime;
            })
        ;
    }

    public function create(array $options = []): Booking
    {
        $options = $this->optionsResolver->resolve($options);

        /** @var Booking $booking */
        $booking = $this->bookingFactory->createNew();
        $booking->setAnimal($options['animal']);
        $booking->setCustomer($options['customer']);
        $booking->setStatus($options['status']);
        $booking->setCreatedAt($options['createdAt']);
        $booking->setValidateAt($options['validateAt']);

        return $booking;
    }
}
