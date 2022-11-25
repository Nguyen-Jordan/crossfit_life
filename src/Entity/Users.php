<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;


#[UniqueEntity(fields: ['email'], message: 'Il existe déjà un compte avec cet email')]
#[ORM\Entity(repositoryClass: UsersRepository::class)]
class Users implements UserInterface, PasswordAuthenticatedUserInterface
{
  #[ORM\Id]
  #[ORM\Column(type: 'uuid', unique: true)]
  #[ORM\GeneratedValue(strategy: 'CUSTOM')]
  #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
  #[Assert\Uuid]
  private ?Uuid $id;

  #[ORM\Column]
  private array $roles = [];

  #[ORM\Column]
  private ?bool $status = null;

  #[ORM\Column(length: 100)]
  #[Assert\NotBlank]
  #[Assert\Length(min: 3, minMessage: "Veuillez avoir au moins 3 caractères")]
  private ?string $firstname = null;

  #[ORM\Column(length: 100)]
  #[Assert\NotBlank]
  #[Assert\Length(min: 3, minMessage: "Veuillez avoir au moins 3 caractères")]
  private ?string $lastname = null;

  #[ORM\Column(length: 180, unique: true)]
  private ?string $email = null;

  /**
   * @var string The hashed password
   */
  #[ORM\Column]
  #[Assert\Regex("^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$")]
  private ?string $password = null;

  #[ORM\Column(type: 'boolean')]
  private $is_verified = false;

  #[ORM\Column(type: 'string', length: 100, nullable: true)]
  private $resetToken = null;

  #[ORM\OneToOne(inversedBy: 'user', cascade: ['persist', 'remove'])]
  private ?Franchises $franchise = null;

  #[ORM\OneToOne(inversedBy: 'user', cascade: ['persist', 'remove'])]
  private ?Structures $structure = null;

  public function getId(): ?Uuid
  {
    return $this->id;
  }

  /**
   * @see UserInterface
   */
  public function getRoles(): array
  {
    $roles = $this->roles;
    $roles[] = 'ROLE_USER';

    return array_unique($roles);
  }

  public function setRoles(array $roles): self
  {
    $this->roles = $roles;

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

  public function getFirstname(): ?string
  {
    return $this->firstname;
  }

  public function setFirstname(string $firstname): self
  {
    $this->firstname = $firstname;

    return $this;
  }

  public function getLastname(): ?string
  {
    return $this->lastname;
  }

  public function setLastname(string $lastname): self
  {
    $this->lastname = $lastname;

    return $this;
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

  public function getIsVerified(): ?bool
  {
    return $this->is_verified;
  }

  public function setIsVerified(bool $is_verified): self
  {
    $this->is_verified = $is_verified;

    return $this;
  }

  public function getResetToken(): ?string
  {
    return $this->resetToken;
  }

  public function setResetToken(?string $resetToken): self
  {
    $this->resetToken = $resetToken;

    return $this;
  }

  public function getFranchise(): ?Franchises
  {
      return $this->franchise;
  }

  public function setFranchise(?Franchises $franchise): self
  {
      $this->franchise = $franchise;

      return $this;
  }

  public function getStructure(): ?Structures
  {
      return $this->structure;
  }

  public function setStructure(?Structures $structure): self
  {
      $this->structure = $structure;

      return $this;
  }
}
