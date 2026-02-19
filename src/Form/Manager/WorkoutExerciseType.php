<?php

declare(strict_types=1);

namespace App\Form\Manager;

use App\Entity\Exercise;
use App\Entity\ExerciseExecution;
use App\Entity\WorkoutExercise;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Required;

class WorkoutExerciseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) : void
    {
        $builder
            ->add('workout', EntityType::class, [
                'class' => \App\Entity\Workout::class,
                'choice_label' => 'id',
                'attr' => ['hidden' => true],
                'constraints' => [
                    new NotNull(message: 'Workout é obrigatório')
                ],
            ])
            ->add('exercise', EntityType::class, [
                'class' => Exercise::class,
                'choice_label' => 'name',
                'placeholder' => 'Selecione um exercício',
                'required' => true,
                'constraints' => [
                    new NotNull(message: 'Selecione um exercício')
                ],
            ])
            ->add('exerciseExecution', EntityType::class, [
                'class' => ExerciseExecution::class,
                'choice_label' => 'short',
                'placeholder' => 'Selecione uma execução',
                'required' => true,
                'constraints' => [
                    new NotNull(message: 'Selecione um exercício')
                ],
            ])
            ->add('position', IntegerType::class, [
                'required' => false,
                'attr' => ['min' => 0],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver) : void
    {
        $resolver->setDefaults([
            'data_class' => WorkoutExercise::class,
        ]);
    }
}
