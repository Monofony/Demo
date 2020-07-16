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

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\PaginatorInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\Animal\Pet;
use App\Repository\PetRepositoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;

final class PetCollectionDataProvider implements CollectionDataProviderInterface, RestrictedDataProviderInterface
{
    /** @var PetRepositoryInterface */
    private $petRepository;

    /** @var RequestStack */
    private $requestStack;

    /** @var string */
    private $locale;

    public function __construct(PetRepositoryInterface $petRepository, RequestStack $requestStack, string $locale)
    {
        $this->petRepository = $petRepository;
        $this->requestStack = $requestStack;
        $this->locale = $locale;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Pet::class === $resourceClass;
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = []): PaginatorInterface
    {
        $request = $this->requestStack->getCurrentRequest();

        return $this->petRepository->createListForApiPaginator($this->locale,  (int) $request->get('page', 1), $context['filters']);

    }
}
