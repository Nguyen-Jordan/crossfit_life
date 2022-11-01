<?php

namespace App\DataFixtures;

use App\Entity\Franchises;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class FranchisesFixtures extends Fixture
{
  
  public function __construct(private SluggerInterface $slugger){}
  
  public function load(ObjectManager $manager): void
  {
      $franchise = $this->createFranchise(1,'Paris', 1, $manager);

      $this->createFranchise(2,'Lyon', 1, $manager);
      $this->createFranchise(3,'Marseille', 0, $manager);
      $this->createFranchise(4,'Bordeaux', 1, $manager);
      $this->createFranchise(5,'Annecy', 1, $manager);
      
      $manager->flush();
  }
  
  public function createFranchise(int $id, string $name, bool $status, ObjectManager $manager)
  {
    $franchise = new Franchises();
    $franchise->setId($id);
    $franchise->setName($name);
    $franchise->setSlug($this->slugger->slug($franchise->getName())->lower());
    $franchise->setStatus($status);
    $manager->persist($franchise);
    
    return $franchise;
  }
}
