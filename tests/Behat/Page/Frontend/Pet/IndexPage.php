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

namespace App\Tests\Behat\Page\Frontend\Pet;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;
use Monofony\Bridge\Behat\Service\JQueryHelper;

class IndexPage extends SymfonyPage
{
    public function getRouteName(): string
    {
        return 'app_frontend_pet_index';
    }

    public function isPetOnList($name)
    {
        return null !== $this->getDocument()->find('css', sprintf('h2:contains("%s")', $name));
    }

    public function filterByColor($color)
    {
        $select = $this->getElement('color_filter', ['%color%' => $color]);
        $select->click();
        JQueryHelper::waitForAsynchronousActionsToFinish($this->getSession());
    }

    public function filterBySex($sex)
    {
        $label = $this->getElement('sex_filter', ['%sex%' => $sex]);
        $label->getParent()->find('css', 'input')->check();
        JQueryHelper::waitForAsynchronousActionsToFinish($this->getSession());
    }

    public function filterBySize($size)
    {
        $label = $this->getElement('size_filter', ['%size%' => $size]);
        $label->getParent()->find('css', 'input')->check();
        JQueryHelper::waitForAsynchronousActionsToFinish($this->getSession());
    }

    public function filterByTaxon($taxonName)
    {
        $label = $this->getElement('taxon_filter', ['%taxon%' => $taxonName]);
        $label->getParent()->find('css', 'input')->check();
        JQueryHelper::waitForAsynchronousActionsToFinish($this->getSession());
    }

    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'color_filter' => '.filter-color .container.color-%color%',
            'sex_filter' => '#criteria_sex .checkbox label:contains("%sex%")',
            'size_filter' => '#criteria_sizeRange .checkbox label:contains("%size%")',
            'taxon_filter' => '#criteria_taxon .checkbox label:contains("%taxon%")',
        ]);
    }
}
