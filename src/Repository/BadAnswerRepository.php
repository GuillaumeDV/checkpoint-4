<?php

namespace App\Repository;

use App\Entity\BadAnswer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BadAnswer|null find($id, $lockMode = null, $lockVersion = null)
 * @method BadAnswer|null findOneBy(array $criteria, array $orderBy = null)
 * @method BadAnswer[]    findAll()
 * @method BadAnswer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BadAnswerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BadAnswer::class);
    }

    // /**
    //  * @return BadAnswer[] Returns an array of BadAnswer objects
    //  */
    /*public function findNameByCategory($value)
    {
        return $this->createQueryBuilder('b')
            //->select('b.name')
            ->andWhere('b.category = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
        ;
    }*/

    /*
    public function findOneBySomeField($value): ?BadAnswer
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
