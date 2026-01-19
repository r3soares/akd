<?php

namespace App\Controller\Admin;

use App\Entity\ExerciseSet;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class ExerciseSetCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ExerciseSet::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('exercise'),
            AssociationField::new('setRep'),
        ];
    }
}
