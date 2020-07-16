<?php

namespace spec\App\ApiPlatform;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use App\ApiPlatform\PetListingEnabledExtension;
use App\Entity\Animal\Pet;
use Doctrine\ORM\QueryBuilder;
use PhpSpec\ObjectBehavior;

class PetListingEnabledExtensionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(PetListingEnabledExtension::class);
    }

    function it_is_a_query_collection()
    {
        $this->shouldImplement(QueryCollectionExtensionInterface::class);
    }

    function it_filters_enabled_pets_only(
        QueryBuilder $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator
    ) {
        $queryBuilder->getRootAliases()->willReturn(['o']);
        $queryBuilder->andWhere(sprintf('%s.enabled = :enabled', 'o'))->willReturn($queryBuilder);
        $queryBuilder->setParameter('enabled', true)->willReturn($queryBuilder);

        $queryBuilder->getRootAliases()->shouldBeCalled();
        $queryBuilder->andWhere(sprintf('%s.enabled = :enabled', 'o'))->shouldBeCalled();
        $queryBuilder->setParameter('enabled', true)->shouldBeCalled();

        $this->applyToCollection($queryBuilder, $queryNameGenerator, Pet::class);
    }
}
