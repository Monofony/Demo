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

use ApiPlatform\Core\Annotation\ApiProperty;
use App\Entity\Animal\Pet;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Taxonomy\Model\Taxon as BaseTaxon;
use Sylius\Component\Taxonomy\Model\TaxonInterface;
use Symfony\Component\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_taxon")
 */
class Taxon extends BaseTaxon implements TaxonInterface
{
    /**
     * {@inheritdoc}
     *
     * @ApiProperty(identifier=false)
     */
    protected $id;

    /**
     * {@inheritdoc}
     *
     * @ApiProperty(identifier=true)
     */
    protected $code;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $sizeRange = null;

    /**
     * @var Collection<int, Pet>
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Animal\Pet", mappedBy="taxon")
     */
    private Collection $pets;

    public function __construct()
    {
        parent::__construct();

        $this->pets = new ArrayCollection();
    }

    public function getSizeRange(): ?string
    {
        return $this->sizeRange;
    }

    public function setSizeRange(?string $sizeRange): void
    {
        $this->sizeRange = $sizeRange;
    }

    /**
     * @Serializer\Groups({"taxon:read"})
     */
    public function getName(): ?string
    {
        return parent::getName();
    }

    /**
     * @return Collection<int, Pet>
     */
    public function getPets(): Collection
    {
        return $this->pets;
    }
}
