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

namespace App\Tests\Behat\Page\Backend\Pet;

use Monofony\Bridge\Behat\Crud\AbstractIndexPage;
use Monofony\Bridge\Behat\Crud\IndexPageInterface;

class IndexPage extends AbstractIndexPage implements IndexPageInterface
{
    /**
     * {@inheritdoc}
     */
    public function getRouteName(): string
    {
        return 'app_backend_pet_index';
    }

    public function filterByTaxon(string $name): void
    {
        $this->getElement('taxon_filter', ['%taxon%' => $name])->click();
    }

    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'taxon_filter' => '.sylius-tree__item a:contains("%taxon%")',
        ]);
    }
}
