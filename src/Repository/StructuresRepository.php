<?php

namespace App\Repository;

use App\Entity\Structures;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Structures>
 *
 * @method Structures|null find($id, $lockMode = null, $lockVersion = null)
 * @method Structures|null findOneBy(array $criteria, array $orderBy = null)
 * @method Structures[]    findAll()
 * @method Structures[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StructuresRepository extends ServiceEntityRepository
{
  public function __construct(ManagerRegistry $registry)
  {
    parent::__construct($registry, Structures::class);
  }
  
  public function add(Structures $entity, bool $flush = false): void
  {
    $this->getEntityManager()->persist($entity);
    
    if ($flush) {
      $this->getEntityManager()->flush();
    }
  }
  
  public function remove(Structures $entity, bool $flush = false): void
  {
    $this->getEntityManager()->remove($entity);
    
    if ($flush) {
      $this->getEntityManager()->flush();
    }
  }
  
  public function findRights($value)
  {
    return $this
      ->createQueryBuilder('s')
      ->select('sd.status, d.name')
      ->join("s.structuresDroits", "sd")
      ->andWhere('sd.structures in (:value)')
      ->join("sd.droits", "d")
      ->setParameter('value', $value)
      ->getQuery()
      ->getArrayResult();
  }
}
  
      //select name, sd.status from structures s
  //    LEFT JOIN structures_droits sd on s.id = sd.structures_id
  //    LEFT JOIN droits d on sd.droits_id = d.id
  //;
//    /**
//     * @return Structures[] Returns an array of Structures objects
//     */
//    public function findBydroits(Structures $value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.structureDroits = s.id')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Structures
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

