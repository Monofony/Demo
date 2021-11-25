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

namespace spec\App\Entity\Taxonomy;

use App\Entity\Taxonomy\Taxon;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Taxonomy\Model\Taxon as BaseTaxon;

class TaxonSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Taxon::class);
    }

    function it_extends_a_taxon_model(): void
    {
        $this->shouldHaveType(BaseTaxon::class);
    }

    function it_has_no_default_size_range()
    {
        $this->getSizeRange()->shouldReturn(null);
    }

    function it_has_a_size_range()
    {
        $this->setSizeRange('Small');
        $this->getSizeRange()->shouldReturn('Small');
    }
}
