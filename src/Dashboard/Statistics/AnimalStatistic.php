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

namespace App\Dashboard\Statistics;

use App\Repository\PetRepository;
use Monofony\Component\Admin\Dashboard\Statistics\StatisticInterface;
use Twig\Environment;

final class AnimalStatistic implements StatisticInterface
{
    /** @var PetRepository */
    private $petRepository;

    /** @var Environment */
    private $engine;

    public function __construct(PetRepository $petRepository, Environment $engine)
    {
        $this->petRepository = $petRepository;
        $this->engine = $engine;
    }

    public function generate(): string
    {
        $amountAnimals = $this->petRepository->countAnimals();

        return $this->engine->render('backend/dashboard/statistics/_amount_of_animals.html.twig', [
            'amountOfPets' => $amountAnimals,
        ]);
    }
}
