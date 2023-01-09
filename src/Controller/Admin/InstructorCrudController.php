<?php

namespace App\Controller\Admin;

use App\Entity\Instructor;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class InstructorCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Instructor::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('instructeur')
            ->setEntityLabelInPlural('instructeurs')
            ->setPageTitle('index', 'Liste des %entity_label_plural%')
            ->setPageTitle('detail', fn (Instructor $instructor) => (string) $instructor->getName())
            ->setPageTitle('edit', fn (Instructor $instructor) => sprintf('Edition de <b>%s</b>', $instructor->getName()));
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('ID'),
            TextField::new('firstname','prénom'),
            TextField::new('lastname','nom'),
            TextField::new('email','courriel'),
            TextField::new('phone','téléphone'),
            IntegerField::new('state','département'),
            TextField::new('club','club'),
        ];
    }

}
