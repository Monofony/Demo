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

namespace App\Entity\Animal;

use App\Entity\IdentifiableTrait;
use App\Entity\Taxonomy\Taxon;
use App\Entity\Taxonomy\TaxonInterface;
use App\Repository\PetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Sylius\Component\Resource\Annotation\SyliusCrudRoutes;
use Sylius\Component\Resource\Model\ResourceInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

#[ORM\Entity(repositoryClass: PetRepository::class)]
#[SyliusCrudRoutes(
    alias: 'app.pet',
    path: '/admin/pets',
    section: 'backend',
    redirect: 'update',
    templates: 'backend/crud',
    grid: 'app_pet',
    vars: [
        'all' => [
            'subheader' => 'app.ui.manage_your_pets',
        ],
    ],
)]
class Pet implements ResourceInterface
{
    use IdentifiableTrait;

    #[ORM\Column(type: 'string')]
    #[NotBlank]
    private ?string $name = null;

    #[ORM\Column(type: 'string', unique: true)]
    #[Gedmo\Slug(fields: ['name'])]
    private ?string $slug = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $size = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $sizeUnit = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $mainColor = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $sex = null;

    #[ORM\ManyToOne(targetEntity: Taxon::class)]
    private ?TaxonInterface $taxon = null;

    #[ORM\OneToMany(
        mappedBy: 'pet',
        targetEntity: PetImage::class,
        cascade: ['persist'],
        orphanRemoval: true,
    )]
    private Collection $images;

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

    public function getImages(): ?Collection
    {
        return $this->images;
    }

    public function getFirstImage(): ?PetImage
    {
        return false !== $this->getImages()->first() ? $this->getImages()->first() : null;
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
}
