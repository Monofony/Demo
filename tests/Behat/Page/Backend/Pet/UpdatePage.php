<?php

/*
 * This file is part of the Monofony demo.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests\Behat\Page\Backend\Pet;

use Monofony\Bridge\Behat\Crud\AbstractUpdatePage;
use Monofony\Bridge\Behat\Crud\UpdatePageInterface;

class UpdatePage extends AbstractUpdatePage implements UpdatePageInterface
{
    public function getRouteName(): string
    {
        return 'app_backend_pet_update';
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
            'name' => '#app_pet_name',
        ]);
    }
}
