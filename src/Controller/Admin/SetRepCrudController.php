<?php

namespace App\Controller\Admin;

use App\Entity\SetRep;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class SetRepCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SetRep::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            IntegerField::new('repetition', 'Repetições'),
            IntegerField::new('sets', 'Séries'),
        ];
    }
}
