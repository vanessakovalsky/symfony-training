<?php

namespace App\DataFixtures;

use App\Entity\Utilisateur;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{

      private $passwordEncoder;

     public function __construct(UserPasswordEncoderInterface $passwordEncoder)
     {
         $this->passwordEncoder = $passwordEncoder;
     }

    public function load(ObjectManager $manager)
    {
        $user = new Utilisateur();
        
        $user->setEmail('v.david@kovalibre.com');
        $user->setRoles(['ROLE_ADMIN']);

        $user->setPassword($this->passwordEncoder->encodePassword(
             $user,
             'symfony0520'
         ));

         $manager->persist($user);
         $manager->flush();

    }
}
