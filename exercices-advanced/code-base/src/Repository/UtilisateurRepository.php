<?php

namespace App\Repository;

use App\Entity\Utilisateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Utilisateur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Utilisateur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Utilisateur[]    findAll()
 * @method Utilisateur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UtilisateurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Utilisateur::class);
    }

    public function countPronosticByUser($user_id)
    {
      return $this->createQueryBuilder('u')
        ->select('COUNT(p.id)')
        ->leftJoin('u.pronostics','p')
        ->andWhere('p.id_user = :user_id')
        ->setParameter('user_id', $user_id)
        ->getQuery()
        ->getResult();
    }
}
