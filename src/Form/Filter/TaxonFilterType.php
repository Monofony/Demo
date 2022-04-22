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

namespace App\Form\Filter;

use App\Entity\Taxonomy\Taxon;
use Doctrine\ORM\EntityRepository;
use Sylius\Bundle\TaxonomyBundle\Doctrine\ORM\TaxonRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class TaxonFilterType extends AbstractType
{
    public function __construct(private string $locale, private RequestStack $requestStack, private TaxonRepository $taxonRepository)
    {
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $taxonSlug = $this->getTaxonSlug();
        $taxon = null;

        if (null !== $taxonSlug) {
            $taxon = $this->taxonRepository->findOneBySlug($taxonSlug, $this->locale);
        }

        $resolver
            ->setDefaults([
                'label' => false,
                'required' => false,
                'placeholder' => 'sylius.ui.all',
                'attr' => [
                    'data-level' => null !== $taxon ? $taxon->getLevel() + 1 : 0,
                    'data-parent-id' => null !== $taxon ? $taxon->getId() : null,
                ],
                'class' => Taxon::class,
                'multiple' => true,
                'choice_value' => 'code',
                'choice_label' => 'name',
                'query_builder' => function (EntityRepository $entityRepository) use ($taxon) {
                    $queryBuilder = $entityRepository->createQueryBuilder('o');

                    $queryBuilder
                        ->addSelect('translation')
                        ->innerJoin('o.translations', 'translation', 'WITH', 'translation.locale = :locale')
                        ->orderBy('o.root')
                        ->addOrderBy('o.left')
                        ->setParameter('locale', $this->locale);

                    if (null !== $taxon) {
                        $queryBuilder
                            ->andWhere('o.left > :taxonLeft')
                            ->andWhere('o.right < :taxonRight')
                            ->andWhere('o.root = :taxonRoot')
                            ->setParameter('taxonLeft', $taxon->getLeft())
                            ->setParameter('taxonRight', $taxon->getRight())
                            ->setParameter('taxonRoot', $taxon->getRoot());
                    } else {
                        $queryBuilder
                            ->andWhere($queryBuilder->expr()->isNull('o.parent'));
                    }

                    return $queryBuilder;
                },
                'expanded' => true,
            ]);
    }

    public function getTaxonSlug(): ?string
    {
        if (null === $request = $this->requestStack->getCurrentRequest()) {
            return null;
        }

        return $request->get('slug');
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return EntityType::class;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return 'app_grid_filter_taxon';
    }
}
