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

namespace App\Entity\Animal;

use App\Entity\Media\File;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity
 * @ORM\Table(name="app_animal_image")
 *
 * @Vich\Uploadable
 */
class PetImage extends File
{
    /**
     * {@inheritdoc}
     *
     * @Vich\UploadableField(mapping="animal_image", fileNameProperty="path")
     */
    #[\Symfony\Component\Validator\Constraints\File(maxSize: '6000000', mimeTypes: ['image/*'])]
    protected $file;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Animal\Pet", inversedBy="images")
     */
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
