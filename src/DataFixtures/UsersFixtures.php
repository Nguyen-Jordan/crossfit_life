<?php

namespace App\DataFixtures;

use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class UsersFixtures extends Fixture
{
    public function __construct(
      private UserPasswordHasherInterface $passwordEncoder,
    ){}
  
    public function load(ObjectManager $manager): void
    {
        $admin = new Users();
        $admin->setEmail('big_boss@crossfitlife.com');
        $admin->setIsVerified(1);
        $admin->setPassword(
          $this->passwordEncoder->hashPassword($admin, 'VivaLaVida')
        );
        $admin->setRoles(['ROLE_ADMIN']);
        
        $manager->persist($admin);
        
        $user = $this->createUser('partenaire_01@crossfitlife.com', 1, 'Nervermind', $manager);
        $this->createUser('partenaire_02@crossfitlife.com', 1, 'Nervermind', $manager);
        $this->createUser('partenaire_03@crossfitlife.com', 1, 'Nervermind', $manager);
        $this->createUser('partenaire_04@crossfitlife.com', 1, 'Nervermind', $manager);
        $this->createUser('partenaire_05@crossfitlife.com', 1, 'Nervermind', $manager);
  
        $this->createUser('manager_01@crossfitlife.com', 1, 'DemonDays', $manager);
        $this->createUser('manager_02@crossfitlife.com', 1, 'DemonDays', $manager);
        $this->createUser('manager_03@crossfitlife.com', 1, 'DemonDays', $manager);
        $this->createUser('manager_04@crossfitlife.com', 1, 'DemonDays', $manager);
        $this->createUser('manager_05@crossfitlife.com', 1, 'DemonDays', $manager);
        $this->createUser('manager_06@crossfitlife.com', 1, 'DemonDays', $manager);
        $this->createUser('manager_07@crossfitlife.com', 1, 'DemonDays', $manager);
        $this->createUser('manager_08@crossfitlife.com', 1, 'DemonDays', $manager);
        $this->createUser('manager_09@crossfitlife.com', 1, 'DemonDays', $manager);
        $this->createUser('manager_10@crossfitlife.com', 1, 'DemonDays', $manager);
  
        $manager->flush();
    }
    
    public function createUser(string $email, bool $isVerified, string $password, ObjectManager $manager)
    {
      $user = new Users();
      $user->setEmail($email);
      $user->setIsVerified($isVerified);
      $user->setPassword(
        $this->passwordEncoder->hashPassword($user, $password)
      );
  
      $manager->persist($user);
      
      return $user;
    }
}
