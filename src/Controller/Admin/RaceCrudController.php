<?php

namespace App\Controller\Admin;

use App\Entity\Race;
use App\Event\SendRaceEmailEvent;
use App\EventListener\RaceEmailer;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\BatchActionDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class RaceCrudController extends AbstractCrudController
{
    private $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }
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
            AssociationField::new('states','Départements concernés')
                ->setFormTypeOptionIfNotSet('by_reference', false),
            AssociationField::new('instructor','Instructeur assigné'),
            BooleanField::new('email_sent','Email déjà envoyé aux instructeur ?'),
            DateTimeField::new('createdAt')->onlyOnDetail(),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        $sendEmail = Action::new('sendEmail', 'Envoyer le mail', 'fa fa-send')
            ->displayIf(static function (Race $entity) {
                return !$entity->isEmailSent();
            })
            ->linkToCrudAction('sendEmail');
        $reSendEmail = Action::new('resendEmail', 'Ré envoyer le mail', 'fa fa-send')
            ->displayIf(static function (Race $entity) {
                return $entity->isEmailSent();
            })
            ->linkToCrudAction('forceSendEmail');

        return $actions
            ->add(Crud::PAGE_INDEX, $reSendEmail)
            ->add(Crud::PAGE_INDEX, $sendEmail);
    }

    public function sendEmail(AdminContext $context){
        $race = $context->getEntity()->getInstance();
        $event = new SendRaceEmailEvent($race);
        $this->eventDispatcher->dispatch($event, SendRaceEmailEvent::NAME);

        return $this->redirect($context->getReferrer());
    }

    public function forceSendEmail(AdminContext $context){
        $race = $context->getEntity()->getInstance();
        $event = new SendRaceEmailEvent($race);
        $this->eventDispatcher->dispatch($event, SendRaceEmailEvent::NAME_FORCE);
        return $this->redirect($context->getReferrer());
    }

}
