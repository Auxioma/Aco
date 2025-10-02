<?php

namespace App\Controller\Admin;

use App\Entity\Metier;
use App\Entity\Slider;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class SliderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Slider::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            AssociationField::new('Metier'),
            ImageField::new('imageName')->setBasePath('/images/slider')->onlyOnIndex(),
            TextField::new('Titre'),
            TextField::new('SousTitre'),
            TextField::new('Paragraphe'),
            TextField::new('imageFile')->setFormType(VichImageType::class)->hideOnIndex(),
        ];
    }

}
