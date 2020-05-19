<?php
namespace App\EventListener;

use App\Entity\Pronostic;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class UpdateDateProno
{
    // the listener methods receive an argument which gives you access to
    // both the entity object of the event and the entity manager itself
    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        // if this listener only applies to certain entity types,
        // add some code to check the entity type as early as possible
        if (!$entity instanceof Pronostic) {
            return;
        }

        // Get the game associated to the pronostic
        $entityManager = $args->getObjectManager();
        $gamesEntity = $entity->getIdGame();
        foreach($gamesEntity as $game){
            $game->setDateDernierPronostic(new \DateTime());
            $entityManager->persist($game);
            $entityManager->flush();
        }
    }
}