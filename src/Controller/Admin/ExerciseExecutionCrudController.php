<?php

namespace App\Controller\Admin;

use App\Entity\ExerciseExecution;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;

class ExerciseExecutionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ExerciseExecution::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Execução de Exercício')
            ->setEntityLabelInPlural('Execuções de Exercício')
            ->setPageTitle(Crud::PAGE_INDEX, 'Execuções de Exercício')
            ->setPageTitle(Crud::PAGE_NEW, 'Criar Execução de Exercício')
            ->setPageTitle(Crud::PAGE_EDIT, 'Editar Execução de Exercício')
            ->setPageTitle(Crud::PAGE_DETAIL, 'Detalhes da Execução de Exercício');
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
            TextField::new('short', 'Abreviação')
                ->setRequired(true)
                ->setMaxLength(50),
            TextareaField::new('description', 'Descrição')
                ->setRequired(true)
                ->setMaxLength(255),
        ];
    }
}
