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

use App\Fixture\Factory\PetExampleFactory;
use Doctrine\Common\Persistence\ObjectManager;

class PetFixture extends AbstractResourceFixture
{
    public function __construct(ObjectManager $objectManager, PetExampleFactory $animalExampleFactory)
    {
        parent::__construct($objectManager, $animalExampleFactory);
    }

    public function getName(): string
    {
        return 'pet';
    }
}
