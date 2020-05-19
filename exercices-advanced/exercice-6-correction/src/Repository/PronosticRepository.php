<?php

namespace App\Repository;

use App\Entity\Pronostic;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Pronostic|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pronostic|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pronostic[]    findAll()
 * @method Pronostic[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PronosticRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pronostic::class);
    }

    public function getPronoByUserGroupedByMatch($user_id){
      $query = $this->createQueryBuilder('p')
                    ->andWhere('p.id_user = :user_id')
                    ->innerJoin('p.id_game', 'games')
                    ->addSelect('games')
                    ->orderBy('games.id')
                    ->setParameter('user_id',$user_id);
      return $query->getQuery()->getResult();
    }

//    /**
//     * @return Pronostic[] Returns an array of Pronostic objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Pronostic
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
