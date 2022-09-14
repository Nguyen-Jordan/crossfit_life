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
      $franchise = $this->createFranchise('Paris', 'partenaire_01@crossfit.com', 1, $manager);

      $this->createFranchise('Lyon', 'partenaire_02@crossfit.com', 1, $manager);
      $this->createFranchise('Marseille', 'partenaire_03@crossfit.com', 0, $manager);
      $this->createFranchise('Bordeaux', 'partenaire_04@crossfit.com', 1, $manager);
      $this->createFranchise('Annecy', 'partenaire_05@crossfit.com', 1, $manager);
      
      $manager->flush();
  }
  
  public function createFranchise(string $name, string $email, bool $status, ObjectManager $manager)
  {
    $franchise = new Franchises();
    $franchise->setName($name);
    $franchise->setEmail($email);
    $franchise->setSlug($this->slugger->slug($franchise->getName())->lower());
    $franchise->setStatus($status);
    $manager->persist($franchise);
    
    return $franchise;
  }
}
