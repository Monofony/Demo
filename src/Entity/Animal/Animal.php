<?php

/*
 * This file is part of the Monofony demo.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity\Animal;

use App\Entity\IdentifiableTrait;
use App\Entity\Taxonomy\Taxon;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Resource\Model\ResourceInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="app_animal")
 */
class Animal implements ResourceInterface
{
    use IdentifiableTrait;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var string|null
     *
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(type="string", length=128, unique=true)
     */
    private $slug;

    /**
     * @var string|null
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @var float|null
     *
     * @ORM\Column(type="decimal", nullable=true)
     */
    private $size;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     *
     * @Assert\Expression(
     *     "value != null or !this.isSizeUnitRequired()",
     *     message="This value should not be blank."
     * )
     */
    private $sizeUnit;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $mainColor;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Animal\AnimalImage", mappedBy="animal", orphanRemoval=true, cascade={"persist"})
     */
    private $images;

    /**
     * @var Taxon|null
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Taxonomy\Taxon")
     */
    private $taxon;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): void
    {
        $this->slug = $slug;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getSize(): ?float
    {
        return $this->size;
    }

    public function setSize(?float $size): void
    {
        $this->size = $size;
    }

    public function getSizeUnit(): ?string
    {
        return $this->sizeUnit;
    }

    public function setSizeUnit(?string $sizeUnit): void
    {
        $this->sizeUnit = $sizeUnit;
    }

    public function getMainColor(): ?string
    {
        return $this->mainColor;
    }

    public function setMainColor(?string $mainColor): void
    {
        $this->mainColor = $mainColor;
    }

    public function isSizeUnitRequired(): bool
    {
        return null != $this->getSize();
    }

    public function getImages(): ?Collection
    {
        return $this->images;
    }

    public function getFirstImage()
    {
        return false !== $this->getImages()->first() ? $this->getImages()->first() : null;
    }

    public function hasImage(AnimalImage $image): bool
    {
        return $this->images->contains($image);
    }

    public function addImage(AnimalImage $image): void
    {
        if (!$this->hasImage($image)) {
            $this->images->add($image);
            $image->setAnimal($this);
        }
    }

    public function removeImage(AnimalImage $image): void
    {
        $this->images->removeElement($image);
        $image->setAnimal(null);
    }

    public function getTaxon(): ?Taxon
    {
        return $this->taxon;
    }

    public function setTaxon(?Taxon $taxon): void
    {
        $this->taxon = $taxon;
    }
}
