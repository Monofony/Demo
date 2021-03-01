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

namespace App\OpenApi;

use ApiPlatform\Core\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\Core\OpenApi\Model\Operation;
use ApiPlatform\Core\OpenApi\Model\PathItem;
use ApiPlatform\Core\OpenApi\Model\RequestBody;
use ApiPlatform\Core\OpenApi\OpenApi;
use Symfony\Component\HttpFoundation\Response;

final class OpenApiFactory implements OpenApiFactoryInterface
{
    private $decorated;

    public function __construct(OpenApiFactoryInterface $decorated)
    {
        $this->decorated = $decorated;
    }

    public function __invoke(array $context = []): OpenApi
    {
        $openApi = $this->decorated->__invoke($context);
        $this->addLoginPathConfiguration($openApi);

        return $openApi;
    }

    private function addLoginPathConfiguration(OpenApi $openApi): void
    {
        $pathItem = new PathItem();
        $responses = [
            Response::HTTP_BAD_REQUEST => ['description' => 'Invalid input'],
            Response::HTTP_OK => [
                'description' => 'Get OAuth2 token',
                'content' => [
                    'application/json' => [
                        'schema' => [
                            'type' => 'object',
                            'properties' => [
                                'access_token' => ['type' => 'string', 'example' => 'OGRhZjMyZjJhY2E3MzE1ZmVhMmVlZTNkYmFhMDViMTQwMWJhMGJhZjdmZTg1NTEwNzYyYjlkMmFiNDFkMDcxNA'],
                                'expires_in' => ['type' => 'integer', 'example' => 3600],
                                'token_type' => ['type' => 'string', 'example' => 'bearer'],
                                'scope' => ['type' => 'string', 'example' => null],
                                'refresh_token' => ['type' => 'string', 'example' => 'ZGM4MjRkZDBjNjA2OGY0OWM0NzdmYWYzMmQ2MDMzNDRjYTViNGE2ZDg3ODEzOWU1ZTFlZmVmMDhlMjNiNTdiZQ'],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $requestBody = new RequestBody();
        $requestBody = $requestBody->withContent(new \ArrayObject([
            'application/json' => [
                'schema' => [
                    'type' => 'object',
                    'properties' => [
                        'client_id' => ['type' => 'string', 'example' => '5rbhrb0iiukokcwk8gow0w4ocgww0oco8g8gsgokwc0wcssg4w'],
                        'client_secret' => ['type' => 'string', 'example' => '2rlxzhijcx448ow4c0gksw4wo8oo4k8kkwwg0osskk8g0k8kw8'],
                        'grant_type' => ['type' => 'string', 'example' => 'password'],
                        'username' => ['type' => 'string', 'example' => 'customer@example.com'],
                        'password' => ['type' => 'string', 'example' => 'password'],
                    ],
                ],
            ],
        ]));

        $operation = new Operation(
            'authentication',
            ['Token'], $responses,
            'Authenticate user',
            'Authenticate an user.',
            null,
            [],
            $requestBody
        );
        $pathItem = $pathItem->withPost($operation);
        $openApi->getPaths()->addPath('/api/oauth/v2/token', $pathItem);
    }
}
