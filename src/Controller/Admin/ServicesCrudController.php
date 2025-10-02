<?php

namespace App\Controller\Admin;

use App\Entity\Services;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ServicesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Services::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            AssociationField::new('Metier'),
            ImageField::new('imageName')->setBasePath('/images/services')->onlyOnIndex(),
            TextField::new('Name'),
            SlugField::new('Slug')->setTargetFieldName('Name'),
            TextareaField::new('Description'),
            TextField::new('imageFile')->setFormType(VichImageType::class)->hideOnIndex(),
        ];
    }
}
