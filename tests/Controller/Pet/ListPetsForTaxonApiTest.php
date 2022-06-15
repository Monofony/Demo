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

use App\Factory\TaxonFactory;
use App\Story\TestPetsStory;
use App\Tests\Controller\JsonApiTestCase;
use App\Tests\Controller\PurgeDatabaseTrait;
use Symfony\Component\HttpFoundation\Response;
use Zenstruck\Foundry\Test\Factories;

final class ListPetsForTaxonApiTest extends JsonApiTestCase
{
    use Factories;
    use PurgeDatabaseTrait;

    /** @test */
    public function it_lists_pets_for_taxon(): void
    {
        TestPetsStory::load();

        $catsTaxon = TaxonFactory::find(['code' => 'cats']);

        $this->client->request('GET', '/api/taxa/' . $catsTaxon->getCode() . '/pets');

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'pet/list_pets_for_taxon_response', Response::HTTP_OK);
    }
}
