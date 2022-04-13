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

namespace App\Entity\Animal;

use App\Entity\Media\File;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @Vich\Uploadable
 */
#[Entity]
#[Table]
class PetImage extends File
{
    /**
     * @Vich\UploadableField(mapping="animal_image", fileNameProperty="path")
     */
    #[\Symfony\Component\Validator\Constraints\File(maxSize: '6000000', mimeTypes: ['image/*'])]
    protected ?\SplFileInfo $file = null;

    #[ManyToOne(targetEntity: Pet::class, inversedBy: 'images')]
    private ?Pet $pet = null;

    public function getPet(): ?Pet
    {
        return $this->pet;
    }

    public function setPet(?Pet $pet): void
    {
        $this->pet = $pet;
    }
}
