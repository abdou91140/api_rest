<?php

namespace App\Repository;

use App\Entity\CardModel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CardModel>
 *
 * @method CardModel|null find($id, $lockMode = null, $lockVersion = null)
 * @method CardModel|null findOneBy(array $criteria, array $orderBy = null)
 * @method CardModel[]    findAll()
 * @method CardModel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CardModelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CardModel::class);
    }


    public function findCarModelSearchQuery($searchQuery)
    {
        return $this->createQueryBuilder('c')
            ->select('b.name as brandName', 'c.name as modelName')
            ->leftJoin('c.brand', 'b')
            ->where('c.name = :searchQueryExact OR c.name LIKE :searchQueryStart OR b.name = :searchQueryExact OR b.name LIKE :searchQueryStart')
            ->setParameter('searchQueryExact', $searchQuery)
            ->setParameter('searchQueryStart', '%' . $searchQuery . '%')
            ->getQuery()
            ->getResult();

    }

    //    /**
//     * @return CardModel[] Returns an array of CardModel objects
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

    //    public function findOneBySomeField($value): ?CardModel
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
