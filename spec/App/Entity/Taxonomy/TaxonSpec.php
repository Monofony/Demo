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

namespace spec\App\Entity\Taxonomy;

use App\Entity\Taxonomy\Taxon;
use PhpSpec\ObjectBehavior;

class TaxonSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(Taxon::class);
    }

    function it_has_no_size_range_by_default(): void
    {
        $this->getSizeRange()->shouldReturn(null);
    }

    function its_size_range_is_mutable(): void
    {
        $this->setSizeRange('small');

        $this->getSizeRange()->shouldReturn('small');
    }
}
