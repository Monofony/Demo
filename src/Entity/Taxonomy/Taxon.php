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

namespace App\Entity\Taxonomy;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Taxonomy\Model\Taxon as BaseTaxon;
use Sylius\Component\Taxonomy\Model\TaxonInterface;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_taxon")
 */
class Taxon extends BaseTaxon implements TaxonInterface
{
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $sizeRange = null;

    public function getSizeRange(): ?string
    {
        return $this->sizeRange;
    }

    public function setSizeRange(?string $sizeRange): void
    {
        $this->sizeRange = $sizeRange;
    }

    #[Groups(groups: ['taxon:read'])]
    public function getName(): ?string
    {
        return parent::getName();
    }
}
