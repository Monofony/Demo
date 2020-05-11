<?php

/*
 * This file is part of the Monofony demo.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Fixture;

use App\Fixture\Factory\AnimalExampleFactory;
use Doctrine\Common\Persistence\ObjectManager;
use Monofony\Plugin\FixturesPlugin\Fixture\AbstractResourceFixture;

class AnimalFixture extends AbstractResourceFixture
{
    public function __construct(ObjectManager $objectManager, AnimalExampleFactory $animalExampleFactory)
    {
        parent::__construct($objectManager, $animalExampleFactory);
    }

    public function getName(): string
    {
        return 'animal';
    }
}
