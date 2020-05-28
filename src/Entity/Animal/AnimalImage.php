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
use Monofony\Component\Core\Model\User\AdminAvatarInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
/**
 * @ORM\Entity
 * @ORM\Table(name="app_animal_image")
 *
 * @Vich\Uploadable
 */
class AnimalImage extends File implements AdminAvatarInterface
{
    /**
     * {@inheritdoc}
     *
     * @Vich\UploadableField(mapping="animal_image", fileNameProperty="path")
     *
     * @Assert\File(maxSize="6000000", mimeTypes={"image/*"})
     */
    protected $file;

    /**
     * @var Animal | null
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Animal\Animal", inversedBy="images")
     */
    private $animal;

    public function getAnimal(): ?Animal
    {
        return $this->animal;
    }

    public function setAnimal(?Animal $animal): void
    {
        $this->animal = $animal;
    }



}
