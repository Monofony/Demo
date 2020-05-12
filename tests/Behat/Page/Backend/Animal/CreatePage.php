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

use Monofony\Bundle\AdminBundle\Tests\Behat\Crud\AbstractCreatePage;
use Monofony\Bundle\AdminBundle\Tests\Behat\Crud\CreatePageInterface;

class CreatePage extends AbstractCreatePage implements CreatePageInterface
{

    public function getRouteName(): string
    {
        return 'app_backend_animal_create';
    }

    public function specifyName(?string $name): void
    {
        $this->getElement('name')->setValue($name);
    }

    public function specifySlug(?string $slug): void
    {
        $this->getElement('slug')->setValue($slug);
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'name' => '#app_animal_name',
            'slug' => '#app_animal_slug',
        ]);
    }
}
