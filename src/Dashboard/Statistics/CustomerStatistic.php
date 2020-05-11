<?php

/*
 * This file is part of the Monofony demo.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Dashboard\Statistics;

use App\Repository\CustomerRepository;
use Monofony\Bundle\AdminBundle\Dashboard\Statistics\StatisticInterface;
use Symfony\Component\Templating\EngineInterface;

class CustomerStatistic implements StatisticInterface
{
    /** @var CustomerRepository */
    private $customerRepository;

    /** @var EngineInterface */
    private $engine;

    public function __construct(CustomerRepository $customerRepository, EngineInterface $engine)
    {
        $this->customerRepository = $customerRepository;
        $this->engine = $engine;
    }

    public function generate(): string
    {
        $amountCustomers = $this->customerRepository->countCustomers();

        return $this->engine->render('backend/dashboard/statistics/_amount_of_customers.html.twig', [
            'amountOfCustomers' => $amountCustomers,
        ]);
    }

    public static function getDefaultPriority(): int
    {
        return -1;
    }
}
