<?php

namespace App\Controller\Admin;

use App\Entity\Authors;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AuthorsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Authors::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('author'),
            TextField::new('password'),
            TextField::new('favoriteBook'),
        ];
    }

    
    
}
