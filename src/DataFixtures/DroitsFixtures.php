<?php

namespace App\DataFixtures;

use App\Entity\Droits;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DroitsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $rights = $this->createRights('Gérer les planning', $manager);
  
        $this->createRights('Envoyer newsletter', $manager);
        $this->createRights('Vente de boissons et barres protéinées', $manager);
        $this->createRights('Entraîneur personnel', $manager);
    
        $manager->flush();
    }
  
    public function createRights(string $name, ObjectManager $manager)
    {
        $rights = new Droits();
        $rights->setName($name);
        $manager->persist($rights);
        
        return $rights;
    }
}
