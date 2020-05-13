<?php

/*
 * This file is part of the Monofony demo.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Form\Type\Animal;

use App\Colors;
use App\Entity\Animal\Animal;
use App\SizeUnits;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnimalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'sylius.ui.name',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'sylius.ui.description',
                'required' => false,
            ])
            ->add('size', NumberType::class, [
                'label' => 'app.ui.size',
                'required' => false,
            ])
            ->add('sizeUnit', ChoiceType::class, [
                'label' => 'app.ui.size_unit',
                'required' => false,
                'placeholder' => '---',
                'choices' => $this->getSizeUnitChoices(),
            ])
            ->add('mainColor', ChoiceType::class, [
                'label' => 'app.ui.main_color',
                'required' => false,
                'placeholder' => '---',
                'choices' => $this->getColorChoices(),
            ]);
    }

    public function getBlockPrefix(): string
    {
        return 'app_animal';
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Animal::class
        ]);
    }

    private function getColorChoices(): array
    {
        return $this->getChoices(Colors::ALL);
    }

    private function getSizeUnitChoices(): array
    {
        return $this->getChoices(SizeUnits::ALL);
    }

    private function getChoices(array $keys): array
    {
        $labels = array_map(function (string $key) {
            return 'app.ui.'.$key;
        }, $keys);
        $choices = array_combine($labels, $keys);

        return $choices;
    }
}
