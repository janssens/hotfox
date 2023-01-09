<?php
// src/EventListener/SearchIndexer.php
namespace App\EventListener;

use App\Entity\Instructor;
use App\Entity\Question;
use App\Entity\Race;
use App\Entity\Reply;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use PharIo\Manifest\Exception;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class RaceEmailer
{

    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function postPersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        if (!$entity instanceof Race) {
            return;
        }

        $entityManager = $args->getObjectManager();

        $today = new \DateTime('now');
        /** @var Race $entity */
        if (!$entity->isEmailSent() && $entity->getDate() > $today){
            $instructors = $entityManager->getRepository(Instructor::class)->findBy(['is_active'=>true]);
            $questions = $entityManager->getRepository(Question::class)->findBy(['is_active'=>true]);
            $replies = $entityManager->getRepository(Reply::class)->findBy(['race' => $entity]);
            $sortedReplies = [];
            /** @var Reply $reply */
            foreach ($replies as $reply){
                $sortedReplies[$reply->getInstructor()->getId()];
            }
            /** @var Instructor $instructor */
            foreach ($instructors as $instructor) {
                if (!isset($sortedReplies[$instructor->getId()])) {
                    $reply = new Reply();
                    $reply->setRace($entity);
                    $reply->setInstructor($instructor);
                    $entityManager->persist($reply);
                    $sortedReplies[$instructor->getId()] = $reply;
                }
            }
            $entityManager->flush();
            foreach ($instructors as $instructor) {
                $email = (new TemplatedEmail())
                    ->from('hello@example.com')
                    ->to(new Address($instructor->getEmail(),$instructor->getName()))
                    //->cc('cc@example.com')
                    //->bcc('bcc@example.com')
                    //->replyTo('fabien@example.com')
                    ->subject('Time for Symfony Mailer!')
                    ->htmlTemplate('emails/new_race.html.twig')
                    ->context([
                        'reply' => $sortedReplies[$instructor->getId()],
                        'questions' => $questions,
                    ]);
                try {
                    $this->mailer->send($email);
                } catch (Exception $e) {
                    var_dump($e);
                    die();
                }
            }

        }

    }
}