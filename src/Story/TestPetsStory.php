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

namespace App\Story;

use App\Colors;
use App\Factory\PetFactory;
use App\Factory\TaxonFactory;
use Zenstruck\Foundry\Story;

final class TestPetsStory extends Story
{
    public function build(): void
    {
        TaxonFactory::new()
            ->withCode('bears')
            ->withName('Bears')
            ->create()
        ;

        TaxonFactory::new()
            ->withCode('cats')
            ->withName('Cats')
            ->create()
        ;

        PetFactory::new()
            ->withName('Winnie')
            ->withTaxon('bears')
            ->withMainColor(Colors::ORANGE)
            ->create()
        ;

        PetFactory::new()
            ->withName('Willy')
            ->withTaxon('cats')
            ->withMainColor(Colors::BLACK)
            ->create()
        ;

        PetFactory::new()
            ->withMainColor(Colors::WHITE)
            ->withTaxon('bears')
            ->many(2)
            ->create()
        ;
    }
}
