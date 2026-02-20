<?php

namespace App\Form\Manager;

use App\Entity\Exercise;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExerciseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nome',
                'required' => true,
                'attr' => [
                    'maxlength' => 255,
                    'placeholder' => 'Ex: Supino reto'
                ]
            ])

            ->add('description', TextareaType::class, [
                'label' => 'Descrição',
                'required' => false,
                'attr' => [
                    'rows' => 3,
                    'placeholder' => 'Descrição opcional'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Exercise::class,
        ]);
    }
}
