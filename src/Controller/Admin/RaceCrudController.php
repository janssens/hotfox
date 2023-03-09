<?php

namespace App\Controller\Admin;

use App\Entity\Race;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class RaceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Race::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('épreuve')
            ->setEntityLabelInPlural('épreuves')
            ->setPageTitle('index', 'Liste des %entity_label_plural%')
            ->setPageTitle('detail', fn (Race $race) => (string) $race->getName())
            ->setPageTitle('edit', fn (Race $race) => sprintf('Edition de <b>%s</b>', $race->getName()));
    }
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('ID')->hideOnForm(),
            TextField::new('name','Nom de l\'événement'),
            DateTimeField::new('date','Date de l\'épreuve'),
            DateTimeField::new('deposit_date','Date de dépot du dossier'),
            AssociationField::new('states','Départements concernés'),
            AssociationField::new('instructor','Instructeur assigné'),
            BooleanField::new('email_sent','Email déjà envoyé aux instructeur ?'),
            DateTimeField::new('createdAt')->onlyOnDetail(),
        ];
    }

}
