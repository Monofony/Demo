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

namespace App\Fixture;

use App\Fixture\Factory\BookingExampleFactory;
use Doctrine\Common\Persistence\ObjectManager;
use Monofony\Plugin\FixturesPlugin\Fixture\AbstractResourceFixture;

final class BookingFixture extends AbstractResourceFixture
{
    public function __construct(ObjectManager $objectManager, BookingExampleFactory $bookingExampleFactory)
    {
        parent::__construct($objectManager, $bookingExampleFactory);
    }

    public function getName(): string
    {
        return 'booking';
    }
}
