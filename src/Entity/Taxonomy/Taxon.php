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

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Sylius\Component\Resource\Annotation\SyliusCrudRoutes;
use Sylius\Component\Resource\Annotation\SyliusRoute;
use Sylius\Component\Taxonomy\Model\Taxon as BaseTaxon;

#[Entity]
#[Table(name: 'sylius_taxon')]
#[SyliusCrudRoutes(
    alias: 'sylius.taxon',
    path: '/admin/taxa',
    section: 'backend',
    redirect: 'update',
    templates: 'backend/taxon',
    except: ['show', 'index'],
    vars: [
        'all' => [
            'subheader' => 'sylius.ui.manage_taxons',
            'templates' => [
                'form' => 'backend/taxon/_form.html.twig',
            ],
        ],
    ],
)]
#[SyliusRoute(
    name: 'sylius_admin_partial_taxon_tree',
    path: '/admin/_partial/taxa/tree',
    methods: ['GET'],
    controller: 'sylius.controller.taxon::indexAction',
    template: '$template',
    repository: ['method' => 'findRootNodes'],
)]
class Taxon extends BaseTaxon implements TaxonInterface
{
}
