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

namespace App\Tests\Controller\Pet;

use App\Story\TestPetsStory;
use App\Tests\Controller\JsonApiTestCase;
use App\Tests\Controller\PurgeDatabaseTrait;
use Symfony\Component\HttpFoundation\Response;
use Zenstruck\Foundry\Test\Factories;

final class ListPetsApiTest extends JsonApiTestCase
{
    use Factories;
    use PurgeDatabaseTrait;

    /** @test */
    public function it_lists_pets(): void
    {
        TestPetsStory::load();

        $this->client->request('GET', '/api/pets');

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'pet/list_pets_response', Response::HTTP_OK);
    }
}
