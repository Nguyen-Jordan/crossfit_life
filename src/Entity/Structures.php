<?php

namespace App\Entity;

use App\Entity\Trait\SlugTrait;
use App\Repository\StructuresRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StructuresRepository::class)]
class Structures
{
    use SlugTrait;
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\ManyToOne(targetEntity: Franchises::class, inversedBy: 'structures')]
    #[ORM\JoinColumn(onDelete: 'CASCADE')]
    private ?Franchises $franchise = null;

    #[ORM\Column]
    private ?bool $status = null;

    #[ORM\OneToMany(mappedBy: 'structures', targetEntity: StructuresDroits::class, cascade: ['persist', 'remove'])]
    private Collection $structuresDroits;

    #[ORM\OneToOne(mappedBy: 'structure', cascade: ['persist', 'remove'])]
    private ?Users $user = null;


    public function __construct($address = null, $status = null)
    {
        $this->address = $address;
        $this->status = $status;
        $this->structuresDroits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId($id): self
    {
      $this->id = $id;

      return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

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
     * @return Collection<int, StructuresDroits>
     */
    public function getStructuresDroits(): Collection
    {
        return $this->structuresDroits;
    }

    public function addStructuresDroit(StructuresDroits $structuresDroit): self
    {
        if (!$this->structuresDroits->contains($structuresDroit)) {
            $this->structuresDroits->add($structuresDroit);
            $structuresDroit->setStructures($this);
        }

        return $this;
    }

    public function removeStructuresDroit(StructuresDroits $structuresDroit): self
    {
        if ($this->structuresDroits->removeElement($structuresDroit)) {
            // set the owning side to null (unless already changed)
            if ($structuresDroit->getStructures() === $this) {
                $structuresDroit->setStructures(null);
            }
        }

        return $this;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): self
    {
        // unset the owning side of the relation if necessary
        if ($user === null && $this->user !== null) {
            $this->user->setStructure(null);
        }

        // set the owning side of the relation if necessary
        if ($user !== null && $user->getStructure() !== $this) {
            $user->setStructure($this);
        }

        $this->user = $user;

        return $this;
    }
}
