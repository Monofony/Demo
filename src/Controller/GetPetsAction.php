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

namespace App\Controller;

use App\Repository\PetRepository;
use Symfony\Component\HttpFoundation\Request;

final class GetPetsAction
{
    /** @var PetRepository */
    private $petRepository;

    public function __construct(PetRepository $petRepository)
    {
        $this->petRepository = $petRepository;
    }

    public function __invoke(Request $request)
    {
        return $this->petRepository->createListForApiPaginator('%locale%', (int) $request->get('page', 1));
    }
}
