<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;


#[UniqueEntity(fields: ['email'], message: 'Il existe déjà un compte avec cet email')]
#[ORM\Entity(repositoryClass: UsersRepository::class)]
class Users implements UserInterface, PasswordAuthenticatedUserInterface
{
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  private ?int $id = null;
  
  #[ORM\Column(length: 180, unique: true)]
  private ?string $email = null;
  
  #[ORM\Column]
  private array $roles = [];
  
  /**
   * @var string The hashed password
   */
  #[ORM\Column]
  private ?string $password = null;
  
  #[ORM\Column(type: 'boolean')]
  private $isVerified = false;
  
  #[ORM\Column]
  private ?bool $status = null;

  #[ORM\OneToOne(mappedBy: 'partner', cascade: ['persist', 'remove'])]
  private ?Franchises $franchise = null;

  #[ORM\OneToOne(mappedBy: 'manager', cascade: ['persist', 'remove'])]
  private ?Structures $structure = null;

  #[ORM\OneToOne(inversedBy: 'user_id', cascade: ['persist', 'remove'])]
  private ?Franchises $franchise_id = null;

  #[ORM\OneToOne(inversedBy: 'user_id', cascade: ['persist', 'remove'])]
  private ?Structures $structure_id = null;
  
  public function getId(): ?int
  {
    return $this->id;
  }
  
  public function getEmail(): ?string
  {
    return $this->email;
  }
  
  public function setEmail(string $email): self
  {
    $this->email = $email;
    
    return $this;
  }
  
  /**
   * A visual identifier that represents this user.
   *
   * @see UserInterface
   */
  public function getUserIdentifier(): string
  {
    return (string)$this->email;
  }
  
  /**
   * @see UserInterface
   */
  public function getRoles(): array
  {
    $roles = $this->roles;
    // guarantee every user at least has ROLE_USER
    $roles[] = 'ROLE_MANAGER';
    
    return array_unique($roles);
  }
  
  public function setRoles(array $roles): self
  {
    $this->roles = $roles;
    
    return $this;
  }
  
  /**
   * @see PasswordAuthenticatedUserInterface
   */
  public function getPassword(): string
  {
    return $this->password;
  }
  
  public function setPassword(string $password): self
  {
    $this->password = $password;
    
    return $this;
  }
  
  /**
   * @see UserInterface
   */
  public function eraseCredentials()
  {
    // If you store any temporary, sensitive data on the user, clear it here
    // $this->plainPassword = null;
  }
  
  public function isVerified(): bool
  {
    return $this->isVerified;
  }
  
  public function setIsVerified(bool $isVerified): self
  {
    $this->isVerified = $isVerified;
    
    return $this;
  }
  
  public function isStatus(): ?bool
  {
    return $this->status;
  }
  
  public function setStatus(bool $status): self
  {
    $this->status = $status;
    
    return $this;
  }

  public function getFranchise(): ?Franchises
  {
      return $this->franchise;
  }

  public function setFranchise(?Franchises $franchise): self
  {
      // unset the owning side of the relation if necessary
      if ($franchise === null && $this->franchise !== null) {
          $this->franchise->setPartner(null);
      }

      // set the owning side of the relation if necessary
      if ($franchise !== null && $franchise->getPartner() !== $this) {
          $franchise->setPartner($this);
      }

      $this->franchise = $franchise;

      return $this;
  }

  public function getStructure(): ?Structures
  {
      return $this->structure;
  }

  public function setStructure(?Structures $structure): self
  {
      // unset the owning side of the relation if necessary
      if ($structure === null && $this->structure !== null) {
          $this->structure->setManager(null);
      }

      // set the owning side of the relation if necessary
      if ($structure !== null && $structure->getManager() !== $this) {
          $structure->setManager($this);
      }

      $this->structure = $structure;

      return $this;
  }

  public function getFranchiseId(): ?Franchises
  {
      return $this->franchise_id;
  }

  public function setFranchiseId(?Franchises $franchise_id): self
  {
      $this->franchise_id = $franchise_id;

      return $this;
  }

  public function getStructureId(): ?Structures
  {
      return $this->structure_id;
  }

  public function setStructureId(?Structures $structure_id): self
  {
      $this->structure_id = $structure_id;

      return $this;
  }
}
