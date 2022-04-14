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

namespace App\Tests\Behat\Context\Setup;

use App\Factory\TaxonFactory;
use Behat\Behat\Context\Context;
use Monofony\Bridge\Behat\Service\SharedStorageInterface;

final class TaxonContext implements Context
{
    public function __construct(private SharedStorageInterface $sharedStorage)
    {
    }

    /**
     * @Given there is a taxon with name :name
     */
    public function thereIsATaxonWithName(string $name): void
    {
        $this->createWithOptions(['name' => $name]);
    }

    private function createWithOptions(array $options): void
    {
        $taxon = TaxonFactory::createOne($options)->object();

        $this->sharedStorage->set('taxon', $taxon);
    }
}
