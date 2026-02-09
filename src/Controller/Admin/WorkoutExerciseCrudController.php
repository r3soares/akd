<?php

namespace App\Controller\Admin;

use App\Entity\WorkoutExercise;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class WorkoutExerciseCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return WorkoutExercise::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Exercício do Treino')
            ->setEntityLabelInPlural('Exercícios do Treino')
            ->setPageTitle(Crud::PAGE_INDEX, 'Exercícios do Treino')
            ->setPageTitle(Crud::PAGE_NEW, 'Adicionar Exercício ao Treino')
            ->setPageTitle(Crud::PAGE_EDIT, 'Editar Exercício do Treino')
            ->setPageTitle(Crud::PAGE_DETAIL, 'Detalhes do Exercício do Treino');
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->onlyOnIndex(),
            AssociationField::new('workout', 'Treino')
                ->setRequired(true),
            AssociationField::new('exercise', 'Exercício')
                ->setRequired(true),
            AssociationField::new('exerciseExecution', 'Execução'),
            IntegerField::new('restTime', 'Tempo de Descanso (s)')
                ->setRequired(false),
            TextField::new('note', 'Observação')
                ->setRequired(false)
                ->setMaxLength(255),
        ];
    }
}
