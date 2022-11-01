<?php

namespace App\DataFixtures;

use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UsersFixtures extends Fixture
{
    public function __construct(
      private UserPasswordHasherInterface $passwordEncoder,
    ){}
  
    public function load(ObjectManager $manager): void
    {
        $admin = new Users();
        $admin->setFirstname('John');
        $admin->setLastname('Doe');
        $admin->setEmail('big_boss@crossfitlife.com');
        $admin->setIsVerified(1);
        $admin->setStatus(1);
        $admin->setPassword(
          $this->passwordEncoder->hashPassword($admin, 'VivaLaVida')
        );
        $admin->setFranchise(null);
        $admin->setStructure(null);
        $admin->setRoles(['ROLE_ADMIN']);
        
        $manager->persist($admin);
        
        $user = $this->createUser(['ROLE_PARTNER'],'Robert','Void','partenaire_01@crossfitlife.com', 1, 'Nevermind', 1,null,1, $manager);
        $this->createUser(['ROLE_PARTNER'],'Philip','Ubik','partenaire_02@crossfitlife.com', 1, 'Nevermind', 1, null, 2, $manager);
        $this->createUser(['ROLE_PARTNER'],'Atsuko','Slan','partenaire_03@crossfitlife.com', 1, 'Nevermind', 1, null, 3, $manager);
        $this->createUser(['ROLE_PARTNER'],'Griffith','Femto','partenaire_04@crossfitlife.com', 1, 'Nevermind', 1,null, 4, $manager);
        $this->createUser(['ROLE_PARTNER'],'joseph','Conrad','partenaire_05@crossfitlife.com', 1, 'Nevermind', 1, null, 5, $manager);
  
        $this->createUser(['ROLE_MANAGER'],'Marie','Dupont','manager_01@crossfitlife.com', 1, 'DemonDays', 1, 1, null, $manager);
        $this->createUser(['ROLE_MANAGER'],'David','Rolin','manager_02@crossfitlife.com', 1, 'DemonDays', 1,1, null, $manager);
        $this->createUser(['ROLE_MANAGER'],'Coralie','Cunégonde','manager_03@crossfitlife.com', 1, 'DemonDays', 1,1, null, $manager);
        $this->createUser(['ROLE_MANAGER'],'Viviane','Léonie','manager_04@crossfitlife.com', 1, 'DemonDays', 1,1, null, $manager);
        $this->createUser(['ROLE_MANAGER'],'Robert','Lemaire','manager_05@crossfitlife.com', 1, 'DemonDays', 1,1, null, $manager);
        $this->createUser(['ROLE_MANAGER'],'Robert','Brondel','manager_06@crossfitlife.com', 1, 'DemonDays', 1,1, null, $manager);
        $this->createUser(['ROLE_MANAGER'],'Laura','Sauvageon','manager_07@crossfitlife.com', 1, 'DemonDays', 1,1, null, $manager);
        $this->createUser(['ROLE_MANAGER'],'Benjamine','Lapointe','manager_08@crossfitlife.com', 1, 'DemonDays', 1,1, null, $manager);
        $this->createUser(['ROLE_MANAGER'],'Mylène','Richard','manager_09@crossfitlife.com', 1, 'DemonDays', 1,1, null, $manager);
        $this->createUser(['ROLE_MANAGER'],'Romain','Berger','manager_10@crossfitlife.com', 1, 'DemonDays', 1,1, null, $manager);
  
        $manager->flush();
    }
    
    public function createUser(array $role, string $firstname,string $lastname, string $email, bool $isVerified, string $password,bool $status, int $structure = null, int $franchise = null, ObjectManager $manager)
    {
      $user = new Users();
      $user->getRoles($role);
      $user->setFirstname($firstname);
      $user->setLastname($lastname);
      $user->setEmail($email);
      $user->setIsVerified($isVerified);
      $user->setPassword(
        $this->passwordEncoder->hashPassword($user, $password)
      );
      $user->setStatus($status);
      $user->setStructure($structure);
      $user->setFranchise($franchise);
      $manager->persist($user);
      
      return $user;
    }
}
