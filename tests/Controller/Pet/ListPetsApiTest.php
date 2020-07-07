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

final class ListPetsApiTest extends JsonApiTestCase
{
    /**
     * @test
     */
    public function it_lists_pets()
    {
        $this->loadFixturesFromFile('resources/fixtures.yaml');
        $this->client->request('GET', '/api/pets');
        $response = $this->client->getResponse();
        $this->assertResponse($response, 'pet/list_pets_response', Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function it_lists_pets_filtered_by_sex()
    {
        $this->loadFixturesFromFile('resources/fixtures.yaml');
        $this->client->request('GET', '/api/pets?sex=male');
        $response = $this->client->getResponse();
        $this->assertResponse($response, 'pet/list_pets_filtered_by_sex_response', Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function it_lists_pets_filtered_by_color()
    {
        $this->loadFixturesFromFile('resources/fixtures.yaml');
        $this->client->request('GET', '/api/pets?mainColor=black');
        $response = $this->client->getResponse();
        $this->assertResponse($response, 'pet/list_pets_filtered_by_color_response', Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function it_lists_pets_filtered_by_size_range()
    {
        $this->loadFixturesFromFile('resources/fixtures.yaml');
        $this->client->request('GET', '/api/pets?taxon.sizeRange=tall');
        $response = $this->client->getResponse();
        $this->assertResponse($response, 'pet/list_pets_filtered_by_size_range_response', Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function it_lists_pets_filtered_by_taxon()
    {
        $resources = $this->loadFixturesFromFile('resources/fixtures.yaml');
        /** @var TaxonInterface $taxonCat */
        $taxonCat = $resources['taxon_cat'];
        $this->client->request('GET', '/api/pets?taxon.code='.$taxonCat->getCode());
        $response = $this->client->getResponse();
        $this->assertResponse($response, 'pet/list_pets_filtered_by_taxon_response', Response::HTTP_OK);
    }
}
