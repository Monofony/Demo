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

namespace App\Tests\Behat\Context\Ui\Frontend;

use App\Tests\Behat\Page\Frontend\HomePage;
use Behat\Behat\Context\Context;

class HomepageContext implements Context
{
    private HomePage $homePage;

    public function __construct(HomePage $homePage)
    {
        $this->homePage = $homePage;
    }
}
