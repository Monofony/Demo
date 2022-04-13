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

namespace App\Dashboard\Statistics;

use App\Repository\PetRepository;
use Monofony\Component\Admin\Dashboard\Statistics\StatisticInterface;
use Twig\Environment;

final class PetStatistic implements StatisticInterface
{
    public function __construct(private PetRepository $petRepository, private Environment $engine)
    {
    }

    public function generate(): string
    {
        $amountOfPets = $this->petRepository->countPets();

        return $this->engine->render('backend/dashboard/statistics/_amount_of_pets.html.twig', [
            'amountOfPets' => $amountOfPets,
        ]);
    }

    public static function getDefaultPriority(): int
    {
        return -1;
    }
}
