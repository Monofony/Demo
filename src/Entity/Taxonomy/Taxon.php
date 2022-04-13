<?php

/*
 * This file is part of Monofony demo project.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Entity\Taxonomy;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Sylius\Component\Taxonomy\Model\Taxon as BaseTaxon;

#[Entity]
#[Table(name: 'sylius_taxon')]
class Taxon extends BaseTaxon implements TaxonInterface
{
}
