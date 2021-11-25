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

use Faker\Factory;
use Faker\Generator;
use FOS\OAuthServerBundle\Model\ClientInterface;
use FOS\OAuthServerBundle\Model\ClientManagerInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApiClientExampleFactory extends AbstractExampleFactory
{
    private Generator $faker;

    private OptionsResolver $optionsResolver;

    public function __construct(private ClientManagerInterface $clientManager)
    {
        $this->faker = Factory::create();
        $this->optionsResolver = new OptionsResolver();

        $this->configureOptions($this->optionsResolver);
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $options = []): ClientInterface
    {
        $options = $this->optionsResolver->resolve($options);

        /** @var ClientInterface $client */
        $client = $this->clientManager->createClient();

        $client->setRandomId($options['random_id']);
        $client->setSecret($options['secret']);

        $client->setAllowedGrantTypes($options['allowed_grant_types']);

        return $client;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefault('random_id', function (Options $options): int {
                return $this->faker->unique()->randomNumber(8);
            })
            ->setDefault('secret', function (Options $options): string {
                return $this->faker->uuid;
            })
            ->setDefault('allowed_grant_types', [])
            ->setAllowedTypes('allowed_grant_types', ['array'])
        ;
    }
}
