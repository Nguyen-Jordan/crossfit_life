<?php

namespace App\DataFixtures;

use App\Entity\Droits;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DroitsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $rights = $this->createRights(1,'Gérer les planning', $manager);
  
        $this->createRights(2,'Envoyer newsletter', $manager);
        $this->createRights(3,'Vente de boissons et barres protéinées', $manager);
        $this->createRights(3,'Entraîneur personnel', $manager);
    
        $manager->flush();
    }
  
    public function createRights(int $id, string $name, ObjectManager $manager)
    {
        $rights = new Droits();
        $rights->setId($id);
        $rights->setName($name);
        $manager->persist($rights);
        
        return $rights;
    }
}
