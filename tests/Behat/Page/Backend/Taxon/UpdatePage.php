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

namespace App\Tests\Behat\Page\Backend\Taxon;

use Monofony\Bundle\AdminBundle\Tests\Behat\Crud\AbstractUpdatePage;
use Monofony\Bundle\AdminBundle\Tests\Behat\Crud\UpdatePageInterface;

final class UpdatePage extends AbstractUpdatePage implements UpdatePageInterface
{
    public function getRouteName(): string
    {
        return 'sylius_backend_taxon_update';
    }

    /**
     * {@inheritdoc}
     */
    public function changeName(?string $name): void
    {
        $this->getElement('name')->setValue($name);
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'name' => '#sylius_taxon_translations_en_US_name',
        ]);
    }
}
