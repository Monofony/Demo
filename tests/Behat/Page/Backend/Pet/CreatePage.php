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

use App\Formatter\StringInflector;
use Behat\Mink\Driver\Selenium2Driver;
use Behat\Mink\Element\NodeElement;
use Behat\Mink\Exception\ElementNotFoundException;
use Monofony\Bridge\Behat\Crud\AbstractCreatePage;
use Monofony\Bridge\Behat\Crud\CreatePageInterface;
use Webmozart\Assert\Assert;

class CreatePage extends AbstractCreatePage implements CreatePageInterface
{
    public function getRouteName(): string
    {
        return 'app_backend_pet_create';
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

    public function specifySize(?float $size): void
    {
        $this->getElement('size')->setValue($size);
    }

    public function specifySizeUnit(?string $sizeUnit): void
    {
        $this->getElement('size_unit')->setValue($sizeUnit);
    }

    public function specifySex(?string $sex): void
    {
        $this->getElement('sex')->setValue($sex);
    }

    public function chooseTaxon(string $taxon): void
    {
        $this->clickTabIfItsNotActive('taxonomy');
        $this->getElement('taxon')->selectOption($taxon);
    }

    public function attachImage(string $path): void
    {
        $this->clickTabIfItsNotActive('media');
        $filesPath = $this->getParameter('files_path');

        $this->getDocument()->clickLink('Add');

        $imageForm = $this->getLastImageElement();

        $imageForm->find('css', 'input[type="file"]')->attachFile($filesPath.$path);
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'name' => '#app_pet_name',
            'sex' => '#app_pet_sex',
            'size' => '#app_pet_size',
            'size_unit' => '#app_pet_sizeUnit',
            'images' => '#app_pet_images',
            'tab' => '.menu [data-tab="%name%"]',
            'taxon' => '#app_pet_taxon',
        ]);
    }

    private function getLastImageElement(): NodeElement
    {
        $images = $this->getElement('images');
        $items = $images->findAll('css', 'div[data-form-collection="item"]');

        Assert::notEmpty($items);

        return end($items);
    }

    private function clickTabIfItsNotActive(string $tabName): void
    {
        if (!$this->getDriver() instanceof Selenium2Driver) {
            return;
        }

        $attributesTab = $this->getElement('tab', ['%name%' => $tabName]);
        if (!$attributesTab->hasClass('active')) {
            $attributesTab->click();
        }
    }
}
