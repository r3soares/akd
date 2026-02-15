<?php

namespace App\Controller\Admin;

use App\Entity\Workout;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class WorkoutCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Workout::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Treino')
            ->setEntityLabelInPlural('Treinos')
            ->setPageTitle(Crud::PAGE_INDEX, 'Treinos')
            ->setPageTitle(Crud::PAGE_NEW, 'Criar Treino')
            ->setPageTitle(Crud::PAGE_EDIT, 'Editar Treino')
            ->setPageTitle(Crud::PAGE_DETAIL, 'Detalhes do Treino');
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
            TextField::new('name', 'Nome')
                ->setRequired(true)
                ->setMaxLength(128),
            AssociationField::new('trainee', 'Aluno'),
        ];
    }
}
