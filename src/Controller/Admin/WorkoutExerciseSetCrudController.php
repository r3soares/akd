<?php

namespace App\Controller\Admin;

use App\Entity\WorkoutExerciseSet;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class WorkoutExerciseSetCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return WorkoutExerciseSet::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('exerciseSet'),
            AssociationField::new('workout'),
        ];
    }
}
