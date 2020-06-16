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

namespace App\Tests\Behat\Page\Frontend\Pet;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;

final class IndexPage extends SymfonyPage
{
    public function getRouteName(): string
    {
        return 'app_frontend_pet_index';
    }

    public function isPetOnList($name)
    {
        return null !== $this->getDocument()->find('css', sprintf('.header:contains("%s")', $name));
    }

    public function filterByTaxon($taxonName)
    {
        $label = $this->getElement('taxon_filter', ['%taxon%' => $taxonName]);
        $label->getParent()->find('css', 'input')->check();
        $this->getElement('taxon_button')->click();
    }

    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'taxon_filter' => '#criteria_taxon .checkbox label:contains("%taxon%")',
            'taxon_button' => '.button.blue.labeled'
        ]);
    }
}
