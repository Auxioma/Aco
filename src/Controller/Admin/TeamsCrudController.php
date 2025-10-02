<?php

namespace App\Controller\Admin;

use App\Entity\Teams;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class TeamsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Teams::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            ImageField::new('imageName')->setBasePath('/images/teams')->onlyOnIndex(),
            TextField::new('Nom'),
            TextField::new('expertise'),
            TextField::new('imageFile')->setFormType(VichImageType::class)->hideOnIndex(),

        ];
    }
}
