<?php

namespace App\Controller\Admin;

use App\Entity\Exercise;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;

class ExerciseCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Exercise::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Exercício')
            ->setEntityLabelInPlural('Exercícios')
            ->setPageTitle(Crud::PAGE_INDEX, 'Exercícios')
            ->setPageTitle(Crud::PAGE_NEW, 'Criar Exercício')
            ->setPageTitle(Crud::PAGE_EDIT, 'Editar Exercício')
            ->setPageTitle(Crud::PAGE_DETAIL, 'Detalhes do Exercício');
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
            TextareaField::new('description', 'Descrição')
                ->setRequired(false)
                ->setMaxLength(255),
        ];
    }
}
