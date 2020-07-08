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

namespace App\Tests\Controller\Customer;

use App\Tests\Controller\JsonApiTestCase;
use Symfony\Component\HttpFoundation\Response;

final class RegisterApiTest extends JsonApiTestCase
{
    /**
     * @test
     */
    public function it_does_not_allow_to_push_message_requests_without_required_data()
    {
        $this->client->request('POST', '/api/push_message_requests', [], [], [
            'CONTENT_TYPE' => 'application/json',
            'HTTP_ACCEPT' => 'application/ld+json',
        ], '{}');
        $response = $this->client->getResponse();
        $this->assertResponse($response, 'push_message/push_message_request_validation', Response::HTTP_BAD_REQUEST);
    }

    /**
     * @test
     */
    public function it_can_register_a_new_customer()
    {
        $this->loadFixturesFromFile('resources/fixtures.yaml');

        $data =
            <<<EOT
        {
            "firstName": "Will",
            "lastName": "Smith",
            "email": "will.smith@example.com",
            "password": "password",
            "phoneNumber": "0783983978"
        }
EOT;

        $this->client->request('POST', '/api/register', [], [], ['CONTENT_TYPE' => 'application/json'], $data);

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'customer/register_customer_response', Response::HTTP_NO_CONTENT);
    }

    /**
     * @test
     */
    public function it_cant_register_a_new_customer_because_email_is_already_used()
    {
        $this->loadFixturesFromFile('resources/fixtures.yaml');

        $data =
            <<<EOT
        {
            "firstName": "Will",
            "lastName": "Smith",
            "email": "api@sylius.com",
            "password": "password",
            "phoneNumber": "0783983978"
        }
EOT;

        $this->client->request('POST', '/api/register', [], [], ['CONTENT_TYPE' => 'application/json'], $data);

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'customer/register_customer_email_already_use_response', Response::HTTP_BAD_REQUEST);
    }
}
