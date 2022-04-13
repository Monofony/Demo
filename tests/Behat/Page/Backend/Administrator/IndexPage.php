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

namespace App\Tests\Behat\Page\Backend\Administrator;

use Monofony\Bridge\Behat\Crud\AbstractIndexPage;
use Monofony\Bridge\Behat\Crud\IndexPageInterface;

class IndexPage extends AbstractIndexPage implements IndexPageInterface
{
    /**
     * {@inheritdoc}
     */
    public function getRouteName(): string
    {
        return 'sylius_backend_admin_user_index';
    }
}
