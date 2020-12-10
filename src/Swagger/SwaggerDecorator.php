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

namespace App\Swagger;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class SwaggerDecorator implements NormalizerInterface
{
    /** @var NormalizerInterface */
    private $decorated;

    public function __construct(NormalizerInterface $decorated)
    {
        $this->decorated = $decorated;
    }

    public function supportsNormalization($data, $format = null)
    {
        return $this->decorated->supportsNormalization($data, $format);
    }

    public function normalize($object, $format = null, array $context = [])
    {
        $docs = $this->decorated->normalize($object, $format, $context);

        $docs['paths']['/api/oauth/v2/token']['post'] = $this->addLoginPathConfiguration();

        return array_merge_recursive($docs);
    }

    private function addLoginPathConfiguration(): array
    {
        return [
            'tags' => ['Token'],
            'operationId' => 'authentification',
            'summary' => 'Authenticate user',
            'requestBody' => [
                'content' => [
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
                ],
                'description' => 'data',
            ],
            'responses' => [
                '400' => ['description' => 'Invalid input'],
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
            ],
        ];
    }
}
