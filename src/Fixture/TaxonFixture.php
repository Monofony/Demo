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

namespace App\Fixture;

use App\Fixture\Factory\TaxonExampleFactory;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

final class TaxonFixture extends AbstractResourceFixture
{
    public function __construct(ObjectManager $objectManager, TaxonExampleFactory $animalExampleFactory)
    {
        parent::__construct($objectManager, $animalExampleFactory);
    }

    public function getName(): string
    {
        return 'taxon';
    }

    /**
     * {@inheritdoc}
     */
    protected function configureResourceNode(ArrayNodeDefinition $resourceNode)
    {
        $resourceNode
            ->children()
                ->scalarNode('name')->cannotBeEmpty()->end()
                ->scalarNode('description')->end()
                ->variableNode('children')->cannotBeEmpty()->defaultValue([])->end()
        ;
    }
}
