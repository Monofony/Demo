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

use App\Entity\Customer\Customer;
use App\Entity\User\AppUser;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AppUserExampleFactory extends AbstractExampleFactory implements ExampleFactoryInterface
{
    private Generator $faker;

    private OptionsResolver $optionsResolver;

    public function __construct()
    {
        $this->faker = Factory::create();
        $this->optionsResolver = new OptionsResolver();

        $this->configureOptions($this->optionsResolver);
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $options = []): AppUser
    {
        $options = $this->optionsResolver->resolve($options);

        $customer = new Customer();
        $customer->setEmail($options['email']);
        $customer->setFirstName($options['first_name']);
        $customer->setLastName($options['last_name']);

        $user = new AppUser();
        $user->setUsername($options['username']);
        $user->setPlainPassword($options['password']);
        $user->setEnabled($options['enabled']);
        $user->addRole('ROLE_USER');

        foreach ($options['roles'] as $role) {
            $user->addRole($role);
        }

        $user->setCustomer($customer);

        return $user;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefault('username', function (Options $options) {
                return $this->faker->userName;
            })

            ->setDefault('email', function (Options $options) {
                return $this->faker->email;
            })

            ->setDefault('first_name', function (Options $options) {
                return $this->faker->firstName;
            })

            ->setDefault('last_name', function (Options $options) {
                return $this->faker->lastName;
            })

            ->setDefault('enabled', true)
            ->setAllowedTypes('enabled', 'bool')

            ->setDefault('password', 'password123')

            ->setDefault('roles', [])
            ->setAllowedTypes('roles', 'array')
        ;
    }
}
