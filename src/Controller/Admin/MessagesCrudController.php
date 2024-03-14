<?php

namespace App\Controller\Admin;

use App\Entity\Messages;
use App\Repository\AuthorsRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MessagesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Messages::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            AssociationField::new('authors')
            ->setFormTypeOptions([
                'query_builder' => function (AuthorsRepository $authorRepository) {
                    return $authorRepository->createQueryBuilder('a')
                        ->orderBy('a.author', 'ASC');
                },
                'choice_label' => 'author',
                'multiple' => true,
            ]),
            
            DateTimeField::new('date'),
            TextEditorField::new('text'),
        ];
    }
}
