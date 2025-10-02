<?php

namespace App\Controller\Admin;

use App\Entity\Metier;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class MetierCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Metier::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('Titre'),
            SlugField::new('Slug')->setTargetFieldName('Titre'),
            TextareaField::new('Description'),
            TextField::new('h1', 'Titre Haut de page "Nos métiers"'),

            TextField::new('h2', 'Titre de la section "Nos métiers"'),
            TextEditorField::new('ShortDescription', 'Text entre 200 et 300 mots max')->hideOnIndex()->setFormType(CKEditorType::class), //CKEditorType::clas

            TextField::new('h3', 'Titre de la section "Nos métiers"'),
            TextEditorField::new('LongDescription', 'Breve expliccation du métier')->hideOnIndex()->setFormType(CKEditorType::class), //CKEditorType::clas
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig');
    }
}
