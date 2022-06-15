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

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\IdentifiableTrait;
use App\Entity\Taxonomy\Taxon;
use App\Entity\Taxonomy\TaxonInterface;
use App\PetStates;
use App\Repository\PetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Sylius\Component\Resource\Annotation\SyliusCrudRoutes;
use Sylius\Component\Resource\Annotation\SyliusRoute;
use Sylius\Component\Resource\Model\ResourceInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Valid;

#[ORM\Entity(repositoryClass: PetRepository::class)]
#[SyliusCrudRoutes(alias: 'app.pet', path: '/admin/pets', section: 'backend', redirect: 'update', templates: 'backend/crud', grid: 'app_pet', except: ['index'], vars: [
    'all' => [
        'subheader' => 'app.ui.manage_your_pets',
        'templates' => [
            'form' => 'backend/pet/_form.html.twig',
        ],
    ],
])]
#[SyliusRoute(name: 'app_backend_pet_index', path: '/admin/pets/', methods: ['GET'], controller: 'app.controller.pet::indexAction', template: 'backend/pet/index.html.twig', vars: ['subheader' => 'app.ui.manage_your_pets', 'icon' => 'cat'], section: 'backend', permission: true, grid: 'app_pet')]
#[SyliusRoute(name: 'app_backend_pet_per_taxon_index', path: '/admin/pets/taxon/{taxonId}', methods: ['GET'], controller: 'app.controller.pet::indexAction', template: 'backend/pet/index.html.twig', vars: ['subheader' => 'app.ui.manage_your_pets', 'icon' => 'cat'], section: 'backend', permission: true, grid: 'app_pet')]
#[SyliusRoute(name: 'app_backend_partial_pet_latest', path: '/admin/_partial/pets/latest/{count}', methods: ['GET'], controller: 'app.controller.pet::indexAction', template: '$template', repository: ['method' => 'findLatest', 'arguments' => ['!!int $count']])]
#[SyliusCrudRoutes(alias: 'app.pet', path: '/pets', identifier: 'slug', section: 'frontend', templates: 'frontend/pet', grid: 'app_frontend_pet', only: ['index', 'show'])]
#[SyliusRoute(name: 'app_frontend_pet_per_taxon_index', path: '/pets/taxon/{slug}', methods: ['GET'], controller: 'app.controller.pet::indexAction', template: 'frontend/pet/index.html.twig', requirements: ['slug' => '.+'], grid: 'app_frontend_pet_per_taxon')]
#[SyliusRoute(name: 'app_frontend_partial_pet_latest', path: '/_partial/pets/latest/{count}', methods: ['GET'], controller: 'app.controller.pet::indexAction', template: '$template', repository: ['method' => 'findLatest', 'arguments' => ['!!int $count']], requirements: ['template' => '[^?]+'])]
#[SyliusRoute(name: 'app_frontend_ajax_pet_index', path: '/ajax/pets', methods: ['GET'], controller: 'app.controller.pet::indexAction', template: 'frontend/pet/index/_main.html.twig', requirements: ['slug' => '.+'], grid: 'app_frontend_pet')]
#[SyliusRoute(name: 'app_frontend_ajax_pet_per_taxon_index', path: '/ajax/pets/taxon/{slug}', methods: ['GET'], controller: 'app.controller.pet::indexAction', template: 'frontend/pet/index/_main.html.twig', requirements: ['slug' => '.+'], grid: 'app_frontend_pet_per_taxon')]
#[ApiResource(
    collectionOperations: ['get'],
    itemOperations: ['get'],
    normalizationContext: ['groups' => ['pet:read', 'file:read']],
)]
class Pet implements ResourceInterface
{
    use IdentifiableTrait;

    #[ORM\Column(type: 'integer')]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ApiProperty(identifier: false)]
    protected ?int $id = null;

    #[ORM\Column(type: 'string')]
    #[NotBlank]
    #[Groups(groups: ['pet:read'])]
    private ?string $name = null;

    #[ORM\Column(type: 'string', unique: true)]
    #[Gedmo\Slug(fields: ['name'])]
    #[ApiProperty(identifier: true)]
    private ?string $slug = null;

    #[ORM\Column(type: 'string')]
    private string $status;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups(groups: ['pet:read'])]
    private ?string $description = null;

    #[ORM\Column(type: 'float', nullable: true)]
    #[Groups(groups: ['pet:read'])]
    private ?float $size = null;

    #[ORM\Column(type: 'string', nullable: true)]
    #[Groups(groups: ['pet:read'])]
    private ?string $sizeUnit = null;

    #[ORM\Column(type: 'string', nullable: true)]
    #[Groups(groups: ['pet:read'])]
    private ?string $mainColor = null;

    #[ORM\Column(type: 'string', nullable: true)]
    #[Groups(groups: ['pet:read'])]
    private ?string $sex = null;

    #[ORM\ManyToOne(targetEntity: Taxon::class)]
    #[NotBlank]
    #[Groups(groups: ['pet:read'])]
    private ?TaxonInterface $taxon = null;

    #[ORM\OneToMany(
        mappedBy: 'pet',
        targetEntity: PetImage::class,
        cascade: ['persist'],
        orphanRemoval: true,
    )]
    #[Valid]
    #[Groups(groups: ['pet:read'])]
    private Collection $images;

    public function __construct()
    {
        $this->status = PetStates::NEW;
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

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
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
