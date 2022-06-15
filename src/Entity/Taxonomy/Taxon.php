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

namespace App\Entity\Taxonomy;

use ApiPlatform\Action\NotFoundAction;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Sylius\Component\Resource\Annotation\SyliusCrudRoutes;
use Sylius\Component\Resource\Annotation\SyliusRoute;
use Sylius\Component\Taxonomy\Model\Taxon as BaseTaxon;

#[Entity]
#[Table(name: 'sylius_taxon')]
#[SyliusCrudRoutes(alias: 'sylius.taxon', path: '/admin/taxa', section: 'backend', redirect: 'update', templates: 'backend/taxon', except: ['show', 'index'], vars: [
    'all' => [
        'subheader' => 'sylius.ui.manage_taxons',
        'templates' => [
            'form' => 'backend/taxon/_form.html.twig',
        ],
    ],
])]
#[SyliusRoute(name: 'sylius_admin_partial_taxon_tree', path: '/admin/_partial/taxa/tree', methods: ['GET'], controller: 'sylius.controller.taxon::indexAction', template: '$template', repository: ['method' => 'findRootNodes'])]
#[SyliusRoute(name: 'sylius_frontend_partial_taxon_root_nodes', path: '/_partial/taxa/root-nodes', methods: ['GET'], controller: 'sylius.controller.taxon::indexAction', template: '$template', repository: ['method' => 'findRootNodes'], requirements: ['template' => '[^?]+'])]
#[SyliusRoute(name: 'app_frontend_partial_taxon_show', path: '/_partial/taxa/{slug}', methods: ['GET'], controller: 'sylius.controller.taxon::showAction', template: '$template', repository: ['method' => 'findOneBySlug', 'arguments' => ['$slug', '%locale%']], requirements: ['template' => '[^?]+', 'slug' => '.+'])]
#[ApiResource(normalizationContext: ['groups' => ['taxon:read']])]
#[Get(controller: NotFoundAction::class, read: false)]
#[GetCollection]
class Taxon extends BaseTaxon implements TaxonInterface
{
    #[ApiProperty(identifier: false)]
    protected $id;

    #[ApiProperty(identifier: true)]
    protected $code;

    #[Column(type: 'string', nullable: true)]
    private ?string $sizeRange = null;

    public function getSizeRange(): ?string
    {
        return $this->sizeRange;
    }

    public function setSizeRange(?string $sizeRange): void
    {
        $this->sizeRange = $sizeRange;
    }
}
