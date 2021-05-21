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

namespace App\Tests\Controller\Taxon;

use App\Tests\Controller\JsonApiTestCase;
use Symfony\Component\HttpFoundation\Response;

final class ListTaxaApiTest extends JsonApiTestCase
{
    /**
     * @test
     */
    public function it_lists_taxa()
    {
        $this->loadFixturesFromFile('resources/fixtures.yaml');
        $this->client->request('GET', '/api/taxa');
        $response = $this->client->getResponse();
        $this->assertResponse($response, 'taxon/list_taxa_response', Response::HTTP_OK);
    }
}
