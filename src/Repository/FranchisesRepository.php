<?php

namespace App\Repository;

use App\Entity\Franchises;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Franchises>
 *
 * @method Franchises|null find($id, $lockMode = null, $lockVersion = null)
 * @method Franchises|null findOneBy(array $criteria, array $orderBy = null)
 * @method Franchises[]    findAll()
 * @method Franchises[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FranchisesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Franchises::class);
    }

    public function add(Franchises $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Franchises $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
  
    public function findRights($value)
    {
      $test = $this
      ->createQueryBuilder('f')
      ->select('f.structuresDroits')
      ->andWhere('sd.franchise_id in (:value)')
      ->setParameter('value', $value)
      ->getQuery()
      ->getArrayResult();
      
      return $test;
      
    }
//    /**
//     * @return Franchises[] Returns an array of Franchises objects
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

//    public function findOneBySomeField($value): ?Franchises
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
