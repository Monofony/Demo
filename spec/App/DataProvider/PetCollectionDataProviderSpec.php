<?php

namespace spec\App\DataProvider;

use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\PaginatorInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\DataProvider\PetCollectionDataProvider;
use App\Entity\Animal\Pet;
use App\Repository\PetRepositoryInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class PetCollectionDataProviderSpec extends ObjectBehavior
{
    function let(PetRepositoryInterface $petRepository, RequestStack $requestStack)
    {
        $this->beConstructedWith($petRepository, $requestStack, 'en_US');
    }
    function it_is_initializable()
    {
        $this->shouldHaveType(PetCollectionDataProvider::class);
    }

    function it_is_a_collection_data_provider()
    {
        $this->shouldImplement(CollectionDataProviderInterface::class);
    }

    function it_is_a_restricted_data_provider()
    {
        $this->shouldImplement(RestrictedDataProviderInterface::class);
    }

    function it_supports_only_pet_resources()
    {
        $this->supports(\stdClass::class)->shouldReturn(false);
        $this->supports(Pet::class)->shouldReturn(true);
    }

    function it_filters_enabled_pets_only(
        RequestStack $requestStack,
        PetRepositoryInterface $petRepository,
        Request $request,
        PaginatorInterface $paginator
    ) {
        $requestStack->getCurrentRequest()->willReturn($request);
        $petRepository->createListForApiPaginator(Argument::cetera())->willReturn($paginator);
        $request->get('page', 1)->willReturn('1');

        $petRepository->createListForApiPaginator(Argument::cetera())->shouldBeCalled();

        $this->getCollection(Pet::class);
    }
}
