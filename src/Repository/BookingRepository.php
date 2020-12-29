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

namespace App\Repository;

use App\Entity\Animal\Pet;
use App\Entity\Booking\Booking;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Sylius\Component\Customer\Model\CustomerInterface;

final class BookingRepository extends EntityRepository
{
    public function countBookings(): int
    {
        return (int) $this->createQueryBuilder('o')
            ->select('COUNT(o.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findLatest(int $count): array
    {
        return $this->createQueryBuilder('o')
            ->addOrderBy('o.createdAt', 'DESC')
            ->setMaxResults($count)
            ->getQuery()
            ->getResult();
    }

    public function findOneByCustomerAndPet(CustomerInterface $customer, Pet $pet): ?Booking
    {
        $queryBuilder =  $this->createQueryBuilder('o')
            ->where('o.customer = :customer')
            ->andWhere('o.pet = :pet')
            ->addOrderBy('o.createdAt', 'DESC')
            ->setMaxResults(1)
            ->setParameter('customer', $customer)
            ->setParameter('pet', $pet)
        ;

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }
}
