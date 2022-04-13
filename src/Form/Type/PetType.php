<?php

/*
 * This file is part of Monofony demo project.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Form\Type;

use App\Colors;
use App\Entity\Animal\Pet;
use App\SizeUnits;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'sylius.ui.name',
            ])
            ->add('description', TextareaType::class, [
                'required' => false,
                'label' => 'sylius.ui.description',
            ])
            ->add('size', NumberType::class, [
                'required' => false,
                'label' => 'app.ui.size',
            ])
            ->add('sizeUnit', ChoiceType::class, [
                'required' => false,
                'label' => 'app.ui.size_unit',
                'placeholder' => '---',
                'choices' => SizeUnits::choices(),
            ])
            ->add('mainColor', ChoiceType::class, [
                'required' => false,
                'label' => 'app.ui.main_color',
                'placeholder' => '---',
                'choices' => Colors::choices(),
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pet::class,
        ]);
    }

    public function getBlockPrefix(): string
    {
        return 'app_pet';
    }
}
