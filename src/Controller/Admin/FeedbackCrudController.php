<?php

namespace App\Controller\Admin;

use App\Entity\Feedback;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class FeedbackCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Feedback::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            ImageField::new('imageName')->setBasePath('/images/feedback')->onlyOnIndex(),
            TextField::new('name'),
            TextField::new('Description'),
            TextField::new('Review'),
            TextField::new('imageFile')->setFormType(VichImageType::class)->hideOnIndex(),

        ];
    }
}
