<?php

namespace App\Repository;

use App\Entity\FranchisesDroits;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FranchisesDroits>
 *
 * @method FranchisesDroits|null find($id, $lockMode = null, $lockVersion = null)
 * @method FranchisesDroits|null findOneBy(array $criteria, array $orderBy = null)
 * @method FranchisesDroits[]    findAll()
 * @method FranchisesDroits[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FranchisesDroitsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FranchisesDroits::class);
    }

    public function add(FranchisesDroits $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(FranchisesDroits $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return FranchisesDroits[] Returns an array of FranchisesDroits objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?FranchisesDroits
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
