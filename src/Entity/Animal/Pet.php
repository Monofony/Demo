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

namespace App\Entity\Animal;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Entity\IdentifiableTrait;
use App\PetStates;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Taxonomy\Model\TaxonInterface;
use Symfony\Component\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="app_animal")
 * @ApiFilter(SearchFilter::class, properties={"sex": "exact", "mainColor" : "exact", "taxon.sizeRange" : "exact", "taxon.code" : "exact"})
 */
class Pet implements ResourceInterface
{
    use IdentifiableTrait;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @ApiProperty(identifier=false)
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank()
     *
     * @Serializer\Groups({"pet:read"})
     */
    private ?string $name = null;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(type="string", length=128, unique=true)
     *
     * @ApiProperty(identifier=true)
     */
    private ?string $slug = null;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $description = null;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private ?float $size = null;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @Assert\Expression(
     *     "value != null or !this.isSizeUnitRequired()",
     *     message="This value should not be blank."
     * )
     */
    private ?string $sizeUnit = null;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $mainColor = null;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @Serializer\Groups({"pet:read"})
     */
    private ?string $sex = null;

    /**
     * @var Collection<int, PetImage>
     *
     * @ORM\OneToMany(targetEntity="PetImage", mappedBy="pet", orphanRemoval=true, cascade={"persist"})
     */
    private Collection $images;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Taxonomy\Taxon", inversedBy="pets")
     *
     * @Assert\NotBlank()
     *
     * @Serializer\Groups({"pet:read"})
     */
    private ?TaxonInterface $taxon = null;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private ?\DateTimeInterface $birthDate = null;

    /**
     * @ORM\Column(type="string")
     */
    private string $status;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $enabled;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->status = PetStates::NEW;
        $this->enabled = false;
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

    /**
     * @return Collection<int, PetImage>
     */
    public function getImages(): ?Collection
    {
        return $this->images;
    }

    public function getFirstImage(): ?PetImage
    {
        $firstImage = $this->getImages()->first();

        return false !== $firstImage ? $firstImage : null;
    }

    public function hasImage(PetImage $image): bool
    {
        return $this->images->contains($image);
    }

    public function addImage(PetImage $image): void
    {
        if (!$this->hasImage($image)) {
            $this->images->add($image);
            $image->setPet($this);
        }
    }

    public function removeImage(PetImage $image): void
    {
        $this->images->removeElement($image);
        $image->setPet(null);
    }

    public function getTaxon(): ?TaxonInterface
    {
        return $this->taxon;
    }

    public function setTaxon(?TaxonInterface $taxon): void
    {
        $this->taxon = $taxon;
    }

    public function getSex(): ?string
    {
        return $this->sex;
    }

    public function setSex(?string $sex): void
    {
        $this->sex = $sex;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(?\DateTimeInterface $birthDate): void
    {
        $this->birthDate = $birthDate;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getEnabled(): bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): void
    {
        $this->enabled = $enabled;
    }

    /**
     * @Serializer\Groups({"pet:read"})
     */
    public function getAge(): ?\DateInterval
    {
        return null !== $this->birthDate ? (new \DateTime('now'))->diff($this->getBirthDate()) : null;
    }
}
