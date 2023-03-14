<?php

namespace App\Controller\Admin;

use App\Entity\Instructor;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class InstructorCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Instructor::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ;
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
            IdField::new('id')->hideOnForm(),
            TextField::new('firstname','prénom'),
            TextField::new('lastname','nom'),
            TextField::new('email','courriel'),
            TelephoneField::new('phone','téléphone'),
            AssociationField::new('state','département'),
            TextField::new('club','club'),
            BooleanField::new('is_active','Peut instruire (actif) ?'),
            AssociationField::new('races','nombre d\'épreuves assignées')->hideOnForm(),
            TextField::new('races_names','épreuves assignées')->onlyOnDetail(),
        ];
    }

}
