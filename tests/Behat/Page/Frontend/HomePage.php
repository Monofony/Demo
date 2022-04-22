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

namespace App\Tests\Behat\Page\Frontend;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;

class HomePage extends SymfonyPage
{
    /**
     * {@inheritdoc}
     */
    public function getRouteName(): string
    {
        return 'app_frontend_homepage';
    }

    public function logOut(): void
    {
        $this->getElement('logout_button')->click();
    }

    public function hasMyAccountButton(): bool
    {
        return $this->hasElement('my_account_button');
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'my_account_button' => '[data-my-account-button]',
        ]);
    }
}
