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

namespace App\Tests\Behat\Page\Backend\Pet;

use Behat\Mink\Element\NodeElement;
use Monofony\Bridge\Behat\Behaviour\NamesIt;
use Monofony\Bridge\Behat\Crud\AbstractCreatePage;
use Monofony\Bridge\Behat\Service\DriverHelper;
use Webmozart\Assert\Assert;

final class CreatePage extends AbstractCreatePage
{
    use NamesIt;

    public function getRouteName(): string
    {
        return 'app_backend_pet_create';
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

        $imageForm->find('css', 'input[type="file"]')->attachFile($filesPath . $path);
    }

    protected function getDefinedElements(): array
    {
        return [
            'name' => '#app_pet_name',
            'images' => '#app_pet_images',
            'tab' => '.menu [data-tab="%name%"]',
            'taxon' => '#app_pet_taxon',
        ];
    }

    private function clickTabIfItsNotActive(string $tabName): void
    {
        if (!DriverHelper::isJavascriptSession($this->getDriver())) {
            return;
        }

        $attributesTab = $this->getElement('tab', ['%name%' => $tabName]);
        if (!$attributesTab->hasClass('active')) {
            $attributesTab->click();
        }
    }

    private function getLastImageElement(): NodeElement
    {
        $images = $this->getElement('images');
        $items = $images->findAll('css', 'div[data-form-collection="item"]');

        Assert::notEmpty($items);

        return end($items);
    }
}
