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

namespace App\Tests\Behat\Context\Setup;

use App\Factory\LocaleFactory;
use Behat\Behat\Context\Context;

final class LocaleContext implements Context
{
    /**
     * @Given there is a default locale
     */
    public function ThereIsADefaultLocale(): void
    {
        LocaleFactory::new()->withDefaultCode()->create();
    }
}
