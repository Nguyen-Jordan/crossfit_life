<?php

namespace App\DataFixtures;

use App\Entity\Structures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class StructuresFixtures extends Fixture
{
  public function __construct(private SluggerInterface $slugger){}
  
    public function load(ObjectManager $manager): void
    {
        $structures = $this->createStructures(1,'72 Rue de Romainville', 1, 1, $manager);
        
        $this->createStructures(2,'64 Bd de Bercy', 1, 1, $manager);
        $this->createStructures(3,'65 Rue du Bourbonnais', 2, 1, $manager);
        $this->createStructures(4,'134 Cr Charlemagne', 2, 1, $manager);
        $this->createStructures(5,'56 Av. de la Madrague de Montredon', 3, 1, $manager);
        $this->createStructures(6,'4 Rue St Adrien', 3, 1, $manager);
        $this->createStructures(7,'296 Av. Thiers', 4, 1, $manager);
        $this->createStructures(8,'40 Av. des 40 Journaux', 4, 1, $manager);
        $this->createStructures(9,'46 Av. de Novel', 5, 1, $manager);
        $this->createStructures(10,'1 Chem. de Viré Moulin', 5, 1, $manager);
        
        $manager->flush();
    }
    
    public function createStructures(int $id, string $address, int $franchise = null, bool $status, ObjectManager $manager)
    {
        $structures = new Structures();
        $structures->setId($id);
        $structures->setAddress($address);
        $structures->setFranchise($franchise);
        $structures->setStatus($status);
        $structures->setSlug($this->slugger->slug($structures->getAddress())->lower());
        $manager->persist($structures);
    }
}
