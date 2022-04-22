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

namespace App\Tests\Behat\Page\Frontend\Pet;

final class IndexPerTaxonPage extends IndexPage
{
    public function getRouteName(): string
    {
        return 'app_frontend_pet_per_taxon_index';
    }
}
