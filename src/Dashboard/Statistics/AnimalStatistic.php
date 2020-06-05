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
use Monofony\Bundle\AdminBundle\Dashboard\Statistics\StatisticInterface;
use Symfony\Component\Templating\EngineInterface;

final class AnimalStatistic implements StatisticInterface
{
    /** @var PetRepository */
    private $petRepository;

    /** @var EngineInterface */
    private $engine;

    public function __construct(PetRepository $petRepository, EngineInterface $engine)
    {
        $this->petRepository = $petRepository;
        $this->engine = $engine;
    }

    public function generate(): string
    {
        $amountAnimals = $this->petRepository->countAnimals();

        return $this->engine->render('backend/dashboard/statistics/_amount_of_animals.html.twig', [
            'amountOfAnimals' => $amountAnimals,
        ]);
    }
}
