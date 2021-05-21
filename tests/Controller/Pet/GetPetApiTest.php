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

namespace App\Tests\Controller\Pet;

use App\Tests\Controller\JsonApiTestCase;
use Symfony\Component\HttpFoundation\Response;

final class GetPetApiTest extends JsonApiTestCase
{
    /**
     * @test
     */
    public function it_gets_pet_details()
    {
        $resources = $this->loadFixturesFromFile('resources/fixtures.yaml');
        $this->client->request('GET', '/api/pets/'.$resources['cat_winnie']->getSlug());
        $response = $this->client->getResponse();
        $this->assertResponse($response, 'pet/get_pet_response', Response::HTTP_OK);
    }
}
