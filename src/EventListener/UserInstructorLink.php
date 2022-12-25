<?php
// src/EventListener/SearchIndexer.php
namespace App\EventListener;

use App\Entity\User;
use App\Entity\Instructor;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class UserInstructorLink
{

    public function prePersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        if (!$entity instanceof User || !$entity instanceof Instructor) {
            return;
        }

        $entityManager = $args->getObjectManager();
        if ($entity instanceof User) {
            /** @var User $entity */
            if (!$entity->getInstructor()){
                if ($instructor = $entityManager->getRepository(Instructor::class)->findOneBy(['email'=>$entity->getEmail()])) {
                    $entity->setInstructor($instructor);
                }
            }
        }else{
            /** @var Instructor $entity */
            if (!$entity->getUser()){
                if ($user = $entityManager->getRepository(User::class)->findOneBy(['email'=>$entity->getEmail()])) {
                    $entity->setUser($user);
                }
            }
        }
    }
}