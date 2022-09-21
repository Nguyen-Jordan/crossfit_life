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
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'franchise', targetEntity: Structures::class, orphanRemoval: true)]
    private Collection $structures;

    #[ORM\Column]
    private ?bool $status = null;

    #[ORM\OneToMany(mappedBy: 'franchise_id', targetEntity: FranchisesDroits::class, orphanRemoval: true)]
    private Collection $franchisesDroits;

    #[ORM\OneToOne(mappedBy: 'franchise_id', cascade: ['persist', 'remove'])]
    private ?Users $user_id = null;

    public function __construct()
    {
        $this->structures = new ArrayCollection();
        $this->franchisesDroits = new ArrayCollection();
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
     * @return Collection<int, FranchisesDroits>
     */
    public function getFranchisesDroits(): Collection
    {
        return $this->franchisesDroits;
    }

    public function addFranchisesDroit(FranchisesDroits $franchisesDroit): self
    {
        if (!$this->franchisesDroits->contains($franchisesDroit)) {
            $this->franchisesDroits->add($franchisesDroit);
            $franchisesDroit->setFranchiseId($this);
        }

        return $this;
    }

    public function removeFranchisesDroit(FranchisesDroits $franchisesDroit): self
    {
        if ($this->franchisesDroits->removeElement($franchisesDroit)) {
            // set the owning side to null (unless already changed)
            if ($franchisesDroit->getFranchiseId() === $this) {
                $franchisesDroit->setFranchiseId(null);
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
            $this->user_id->setFranchiseId(null);
        }

        // set the owning side of the relation if necessary
        if ($user_id !== null && $user_id->getFranchiseId() !== $this) {
            $user_id->setFranchiseId($this);
        }

        $this->user_id = $user_id;

        return $this;
    }
}
