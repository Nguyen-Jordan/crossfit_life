<?php

namespace App\DataFixtures;

use App\Entity\StructuresDroits;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class StructuresDroitsFixtures extends Fixture
{
  public function __construct(){}
  
  public function load(ObjectManager $manager): void
  {
    $structures = $this->createStructuresDroits(null,1, 1,1, $manager);

    $this->createStructuresDroits(null,1, 2,1, $manager);
    $this->createStructuresDroits(null,1, 3,0, $manager);
    $this->createStructuresDroits(null,1, 4,0, $manager);
    $this->createStructuresDroits(null,2, 1,1, $manager);
    $this->createStructuresDroits(null,2, 2,1, $manager);
    $this->createStructuresDroits(null,2, 3,0, $manager);
    $this->createStructuresDroits(null,2, 4,0, $manager);
    $this->createStructuresDroits(null,3, 1,1, $manager);
    $this->createStructuresDroits(null,3, 2,1, $manager);
    $this->createStructuresDroits(null,3, 3,0, $manager);
    $this->createStructuresDroits(null,3, 4,0, $manager);
    $this->createStructuresDroits(null,4, 1,1, $manager);
    $this->createStructuresDroits(null,4, 2,1, $manager);
    $this->createStructuresDroits(null,4, 3,0, $manager);
    $this->createStructuresDroits(null,4, 4,0, $manager);
    $this->createStructuresDroits(null,5, 1,1, $manager);
    $this->createStructuresDroits(null,5, 2,1, $manager);
    $this->createStructuresDroits(null,5, 3,0, $manager);
    $this->createStructuresDroits(null,5, 4,0, $manager);
    $this->createStructuresDroits(1,null, 1,1, $manager);
    $this->createStructuresDroits(1,null, 2,1, $manager);
    $this->createStructuresDroits(1,null, 3,0, $manager);
    $this->createStructuresDroits(1,null, 4,0, $manager);
    $this->createStructuresDroits(2,null, 1,1, $manager);
    $this->createStructuresDroits(2,null, 2,1, $manager);
    $this->createStructuresDroits(2,null, 3,0, $manager);
    $this->createStructuresDroits(2,null, 4,0, $manager);
    $this->createStructuresDroits(3,null, 1,1, $manager);
    $this->createStructuresDroits(3,null, 2,1, $manager);
    $this->createStructuresDroits(3,null, 3,0, $manager);
    $this->createStructuresDroits(3,null, 4,0, $manager);
    $this->createStructuresDroits(4,null, 1,1, $manager);
    $this->createStructuresDroits(4,null, 2,1, $manager);
    $this->createStructuresDroits(4,null, 3,0, $manager);
    $this->createStructuresDroits(4,null, 4,0, $manager);
    $this->createStructuresDroits(5,null, 1,1, $manager);
    $this->createStructuresDroits(5,null, 2,1, $manager);
    $this->createStructuresDroits(5,null, 3,0, $manager);
    $this->createStructuresDroits(5,null, 4,0, $manager);
    $this->createStructuresDroits(6,null, 1,1, $manager);
    $this->createStructuresDroits(6,null, 2,1, $manager);
    $this->createStructuresDroits(6,null, 3,0, $manager);
    $this->createStructuresDroits(6,null, 4,0, $manager);
    $this->createStructuresDroits(7,null, 1,1, $manager);
    $this->createStructuresDroits(7,null, 2,1, $manager);
    $this->createStructuresDroits(7,null, 3,0, $manager);
    $this->createStructuresDroits(7,null, 4,0, $manager);
    $this->createStructuresDroits(8,null, 1,1, $manager);
    $this->createStructuresDroits(8,null, 2,1, $manager);
    $this->createStructuresDroits(8,null, 3,0, $manager);
    $this->createStructuresDroits(8,null, 4,0, $manager);
    $this->createStructuresDroits(9,null, 1,1, $manager);
    $this->createStructuresDroits(9,null, 2,1, $manager);
    $this->createStructuresDroits(9,null, 3,0, $manager);
    $this->createStructuresDroits(9,null, 4,0, $manager);
    $this->createStructuresDroits(10,null, 1,1, $manager);
    $this->createStructuresDroits(10,null, 2,1, $manager);
    $this->createStructuresDroits(10,null, 3,0, $manager);
    $this->createStructuresDroits(10,null, 4,0, $manager);
    
    $manager->flush();
  }
  
  public function createStructuresDroits(int $structure = null, int $franchise = null, int $droit = null, bool $status, ObjectManager $manager)
  {
    $structures = new StructuresDroits();
    $structures->setStructures($structure);
    $structures->setFranchise($franchise);
    $structures->setDroits($droit);
    $structures->setStatus($status);
    $manager->persist($structures);
  }
}