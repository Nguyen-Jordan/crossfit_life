<?php

namespace App\DataFixtures;

use App\Entity\StructuresDroits;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class StructuresDroitsFixtures extends Fixture
{
  public function __construct(private SluggerInterface $slugger){}
  
  public function load(ObjectManager $manager): void
  {
    $structures = $this->createStructures('72 Rue de Romainville, 75019 Paris', 'manager_01@crossfitlife.com', 1, $manager);
    
    $this->createStructures('64 Bd de Bercy, 75012 Paris', 'manager_02@crossfitlife.com', 1, $manager);
    $this->createStructures('65 Rue du Bourbonnais, 69009 Lyon', 'manager_03@crossfitlife.com', 1, $manager);
    $this->createStructures('134 Cr Charlemagne, 69002 Lyon', 'manager_04@crossfitlife.com', 1, $manager);
    $this->createStructures('56 Av. de la Madrague de Montredon, 13008 Marseille', 'manager_05@crossfitlife.com', 1, $manager);
    $this->createStructures('4 Rue St Adrien, 13008 Marseille', 'manager_06@crossfitlife.com', 1, $manager);
    $this->createStructures('296 Av. Thiers, 33100 Bordeaux', 'manager_07@crossfitlife.com', 1, $manager);
    $this->createStructures('40 Av. des 40 Journaux, 33000 Bordeaux', 'manager_08@crossfitlife.com', 1, $manager);
    $this->createStructures('46 Av. de Novel, 74000 Annecy', 'manager_09@crossfitlife.com', 1, $manager);
    $this->createStructures('1 Chem. de Viré Moulin, 74940 Annecy', 'manager_10@crossfitlife.com', 1, $manager);
    
    $manager->flush();
  }
  
  public function createStructuresDroits(int $structure, int $droit, bool $status, ObjectManager $manager)
  {
    $structures = new StructuresDroits();
    $structures->setStructures($structure);
    $structures->setDroits($droit);
    $structures->setStatus($status);
    $manager->persist($structures);
  }
}