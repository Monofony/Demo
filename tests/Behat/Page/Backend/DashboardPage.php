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

namespace App\Tests\Behat\Page\Backend;

use Behat\Mink\Session;
use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;
use Monofony\Bridge\Behat\Service\Accessor\TableAccessorInterface;
use Symfony\Component\Routing\RouterInterface;

class DashboardPage extends SymfonyPage
{
    /** @var TableAccessorInterface */
    private $tableAccessor;

    public function __construct(
        Session $session,
        $minkParameters,
        RouterInterface $router,
        TableAccessorInterface $tableAccessor
    ) {
        parent::__construct($session, $minkParameters, $router);

        $this->tableAccessor = $tableAccessor;
    }

    public function getRouteName(): string
    {
        return 'app_backend_dashboard';
    }

    public function getNumberOfNewAnimalsInTheList(): int
    {
        return $this->tableAccessor->countTableBodyRows($this->getElement('animal_list'));
    }

    public function getNumberOfNewBookingsInTheList(): int
    {
        return $this->tableAccessor->countTableBodyRows($this->getElement('booking_list'));
    }

    public function getNumberOfNewCustomersInTheList(): int
    {
        return $this->tableAccessor->countTableBodyRows($this->getElement('customer_list'));
    }

    public function getNumberOfNewPets(): int
    {
        return (int) $this->getElement('new_animals')->getText();
    }

    public function getNumberOfNewBookings(): int
    {
        return (int) $this->getElement('new_bookings')->getText();
    }

    public function getNumberOfNewCustomers(): int
    {
        return (int) $this->getElement('new_customers')->getText();
    }

    public function logOut(): void
    {
        $this->getElement('logout')->click();
    }

    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'animal_list' => '#animals',
            'booking_list' => '#bookings',
            'customer_list' => '#customers',
            'logout' => '#sylius-logout-button',
            'new_animals' => '#new-animals',
            'new_bookings' => '#new-bookings',
            'new_customers' => '#new-customers',
        ]);
    }
}
