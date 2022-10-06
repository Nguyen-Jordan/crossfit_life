<?php

namespace App\Repository;

use App\Entity\Structures;
use App\Entity\StructuresDroits;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StructuresDroits>
 *
 * @method StructuresDroits|null find($id, $lockMode = null, $lockVersion = null)
 * @method StructuresDroits|null findOneBy(array $criteria, array $orderBy = null)
 * @method StructuresDroits[]    findAll()
 * @method StructuresDroits[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StructuresDroitsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StructuresDroits::class);
    }

    public function add(StructuresDroits $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(StructuresDroits $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


  public function findRightsFranchise($value)
  {
    return $this
      ->createQueryBuilder('sd')
      ->select('d.name')
      ->join("sd.droits", "d")
      ->andWhere('sd.franchise in (:value)')
      ->setParameter('value', $value)
      ->getQuery()
      ->getArrayResult();
  }
    
    
//    /**
//     * @return StructuresDroits[] Returns an array of StructuresDroits objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?StructuresDroits
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
