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

use App\Formatter\StringInflector;
use Behat\Mink\Exception\ElementNotFoundException;
use Monofony\Bundle\AdminBundle\Tests\Behat\Crud\AbstractCreatePage;
use Monofony\Bundle\AdminBundle\Tests\Behat\Crud\CreatePageInterface;

class CreatePage extends AbstractCreatePage implements CreatePageInterface
{
    public function getRouteName(): string
    {
        return 'app_backend_animal_create';
    }

    public function checkValidationMessageFor($element, $message): bool
    {
        $element = StringInflector::nameToCode($element);

        $errorLabel = $this->getElement($element)->getParent()->find('css', '.sylius-validation-error');

        if (null === $errorLabel) {
            throw new ElementNotFoundException($this->getSession(), 'Validation message', 'css', '.sylius-validation-error');
        }

        return $message === $errorLabel->getText();
    }

    public function specifyName(?string $name): void
    {
        $this->getElement('name')->setValue($name);
    }

    public function specifySlug(?string $slug): void
    {
        $this->getElement('slug')->setValue($slug);
    }

    public function specifySize(?float $size): void
    {
        $this->getElement('size')->setValue($size);
    }

    public function specifySizeUnit(?string $sizeUnit): void
    {
        $this->getElement('size_unit')->setValue($sizeUnit);
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'name' => '#app_animal_name',
            'slug' => '#app_animal_slug',
            'size' => '#app_animal_size',
            'size_unit' => '#app_animal_sizeUnit',
        ]);
    }
}
