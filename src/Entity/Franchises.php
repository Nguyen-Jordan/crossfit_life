<?php

namespace App\Entity;

use App\Entity\Trait\SlugTrait;
use App\Repository\FranchisesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FranchisesRepository::class)]
class Franchises
{
    use SlugTrait;
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'franchise', targetEntity: Structures::class, orphanRemoval: true)]
    private Collection $structures;

    #[ORM\Column]
    private ?bool $status = null;

    #[ORM\OneToMany(mappedBy: 'franchise', targetEntity: StructuresDroits::class, cascade: ['persist', 'remove'])]
    private Collection $structuresDroits;

    #[ORM\OneToOne(mappedBy: 'franchise', cascade: ['persist', 'remove'])]
    private ?Users $user = null;


    public function __construct($name = null, $status = null)
    {
        $this->name = $name;
        $this->status = $status;
        $this->structures = new ArrayCollection();
        $this->structuresDroits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
    
    /**
     * @return Collection<int, Structures>
     */
    public function getStructures(): Collection
    {
        return $this->structures;
    }

    public function addStructures(Structures $structures): self
    {
        if (!$this->structures->contains($structures)) {
            $this->structures->add($structures);
            $structures->setFranchise($this);
        }

        return $this;
    }

    public function removeStructures(Structures $structures): self
    {
        if ($this->structures->removeElement($structures)) {
            // set the owning side to null (unless already changed)
            if ($structures->getFranchise() === $this) {
                $structures->setFranchise(null);
            }
        }

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

    /**
     * @param StructuresDroits $structuresDroit
     * @return Collection<int, StructuresDroits>
     */
    public function getStructuresDroits(): Collection
    {
        return $this->structuresDroits;
    }

    public function addStructuresDroit(StructuresDroits $structuresDroit): self
    {
        if (!$this->structuresDroits->contains($structuresDroit)) {
            $this->structuresDroits[] = $structuresDroit;
            $structuresDroit->setFranchise($this);
        }

        return $this;
    }

    public function removeStructuresDroit(StructuresDroits $structuresDroit): self
    {
        if ($this->structuresDroits->removeElement($structuresDroit)) {
            // set the owning side to null (unless already changed)
            if ($structuresDroit->getFranchise() === $this) {
                $structuresDroit->setFranchise(null);
            }
        }

        return $this;
    }

  public function __toString(): string
  {
    return $this->name;
  }

  public function getUser(): ?Users
  {
      return $this->user;
  }

  public function setUser(?Users $user): self
  {
      // unset the owning side of the relation if necessary
      if ($user === null && $this->user !== null) {
          $this->user->setFranchise(null);
      }

      // set the owning side of the relation if necessary
      if ($user !== null && $user->getFranchise() !== $this) {
          $user->setFranchise($this);
      }

      $this->user = $user;

      return $this;
  }

}
