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

namespace App\Grid\Frontend;

use App\Entity\Booking\Booking;
use Sylius\Bundle\GridBundle\Builder\Field\DateTimeField;
use Sylius\Bundle\GridBundle\Builder\GridBuilderInterface;
use Sylius\Bundle\GridBundle\Grid\AbstractGrid;
use Sylius\Bundle\GridBundle\Grid\ResourceAwareGridInterface;
use Sylius\Component\Customer\Context\CustomerContextInterface;

final class BookingGrid extends AbstractGrid implements ResourceAwareGridInterface
{
    public function __construct(private CustomerContextInterface $customerContext)
    {
    }

    public static function getName(): string
    {
        return 'app_frontend_booking';
    }

    public function buildGrid(GridBuilderInterface $gridBuilder): void
    {
        $gridBuilder
            ->setRepositoryMethod('createListForFrontQueryBuilder', ['booker' => $this->customerContext->getCustomer()])
            ->addOrderBy('createdAt', 'desc')
            ->setLimits([5])
            ->addField(
                DateTimeField::create('createdAt', 'Y-m-d')
                    ->setLabel('sylius.ui.registration_date')
                    ->setSortable(true),
            )
        ;
    }

    public function getResourceClass(): string
    {
        return Booking::class;
    }
}
