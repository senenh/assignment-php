<?php

namespace App\Repository;

use App\Entity\KeyLanguageTranslation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method KeyLanguageTranslation|null find($id, $lockMode = null, $lockVersion = null)
 * @method KeyLanguageTranslation|null findOneBy(array $criteria, array $orderBy = null)
 * @method KeyLanguageTranslation[]    findAll()
 * @method KeyLanguageTranslation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KeyLanguageTranslationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, KeyLanguageTranslation::class);
    }

    // /**
    //  * @return KeyLanguageTranslation[] Returns an array of KeyLanguageTranslation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('k')
            ->andWhere('k.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('k.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?KeyLanguageTranslation
    {
        return $this->createQueryBuilder('k')
            ->andWhere('k.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
