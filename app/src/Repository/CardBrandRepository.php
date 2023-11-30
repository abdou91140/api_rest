<?php

namespace App\Repository;

use App\Entity\CardBrand;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CardBrand>
 *
 * @method CardBrand|null find($id, $lockMode = null, $lockVersion = null)
 * @method CardBrand|null findOneBy(array $criteria, array $orderBy = null)
 * @method CardBrand[]    findAll()
 * @method CardBrand[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CardBrandRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CardBrand::class);
    }

//    /**
//     * @return CardBrand[] Returns an array of CardBrand objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CardBrand
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
