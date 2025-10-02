<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class CategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Category::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('Name'),
            SlugField::new('Slug')->setTargetFieldName('Name'),
            TextField::new('hn', 'Balise H1')->hideOnIndex(),
            TextField::new('MetaTitre', 'Meta Titre')->hideOnIndex(),
            TextField::new('MetaDescription', 'Meta Description')->hideOnIndex(),
            TextField::new('imageFile')->setFormType(VichImageType::class)->hideOnIndex(),
            ImageField::new('imageName')->setBasePath('/images/categories')->onlyOnIndex(),
        ];
    }
}
