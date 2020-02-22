<?php

namespace App\Repository;

use App\Entity\ArticlePhoto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ArticlePhoto|null find($id, $lockMode = null, $lockVersion = null)
 * @method ArticlePhoto|null findOneBy(array $criteria, array $orderBy = null)
 * @method ArticlePhoto[]    findAll()
 * @method ArticlePhoto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticlePhotoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ArticlePhoto::class);
    }

    // /**
    //  * @return ArticlePhoto[] Returns an array of ArticlePhoto objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ArticlePhoto
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
