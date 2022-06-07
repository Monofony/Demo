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

namespace App\Grid\Filter;

use Sylius\Component\Grid\Data\DataSourceInterface;
use Sylius\Component\Grid\Filtering\FilterInterface;
use Sylius\Component\Taxonomy\Model\TaxonInterface;
use Sylius\Component\Taxonomy\Repository\TaxonRepositoryInterface;

final class TaxonFilter implements FilterInterface
{
    public function __construct(
        private TaxonRepositoryInterface $taxonRepository,
        private string $locale,
    ) {
    }

    /**
     * {@inheritdoc}
     */
    public function apply(DataSourceInterface $dataSource, string $name, $data, array $options = []): void
    {
        if (empty($data)) {
            return;
        }

        $field = (string) $this->getOption($options, 'field', $name);
        $taxonExpressions = [];

        $taxons = is_array($data) ? $data : [$data];

        foreach ($taxons as $taxonCode) {
            /** @var TaxonInterface $taxon */
            $taxon = $this->taxonRepository->findOneBy(['code' => $taxonCode]);

            if (null === $taxon) {
                return;
            }

            $taxonExpressions[] = $dataSource->getExpressionBuilder()->andX(
                $dataSource->getExpressionBuilder()->greaterThanOrEqual(sprintf('%s.left', $field), $taxon->getLeft()),
                $dataSource->getExpressionBuilder()->lessThanOrEqual(sprintf('%s.right', $field), $taxon->getRight()),
                $dataSource->getExpressionBuilder()->equals(sprintf('%s.root', $field), $taxon->getRoot()),
            );
        }

        $dataSource->restrict(
            $dataSource->getExpressionBuilder()->andX(
                $dataSource->getExpressionBuilder()->orX(
                    ...$taxonExpressions,
                ),
            ),
        );
    }

    private function getOption(array $options, string $name, string $default)
    {
        return $options[$name] ?? $default;
    }
}
