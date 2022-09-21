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

    #[ORM\OneToMany(mappedBy: 'structures', targetEntity: StructuresDroits::class)]
    private Collection $structuresDroits;

    #[ORM\OneToOne(mappedBy: 'structure_id', cascade: ['persist', 'remove'])]
    private ?Users $user_id = null;

    public function __construct()
    {
        $this->structuresDroits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getUserId(): ?Users
    {
        return $this->user_id;
    }

    public function setUserId(?Users $user_id): self
    {
        // unset the owning side of the relation if necessary
        if ($user_id === null && $this->user_id !== null) {
            $this->user_id->setStructureId(null);
        }

        // set the owning side of the relation if necessary
        if ($user_id !== null && $user_id->getStructureId() !== $this) {
            $user_id->setStructureId($this);
        }

        $this->user_id = $user_id;

        return $this;
    }
}
