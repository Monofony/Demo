<?php

/*
 * This file is part of the Monofony demo.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests\Behat\Page\Backend\Animal;

use Monofony\Bundle\AdminBundle\Tests\Behat\Crud\AbstractUpdatePage;
use Monofony\Bundle\AdminBundle\Tests\Behat\Crud\UpdatePageInterface;

class UpdatePage extends AbstractUpdatePage implements UpdatePageInterface
{
    public function getRouteName(): string
    {
        return 'app_backend_animal_update';
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
            'name' => '#app_animal_name',
        ]);
    }
}
