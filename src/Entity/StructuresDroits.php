<?php

namespace App\Entity;

use App\Repository\StructuresDroitsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StructuresDroitsRepository::class)]
class StructuresDroits
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'structuresDroits')]
    #[ORM\JoinColumn(onDelete: 'CASCADE')]
    private ?Structures $structures = null;


    #[ORM\ManyToOne(inversedBy: 'structuresDroits')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Droits $droits = null;

    #[ORM\Column]
    private ?bool $status = null;

    #[ORM\ManyToOne(inversedBy: 'structuresDroits')]
    private ?Franchises $franchise = null;

    public function getId(): ?int
    {
      return $this->id;
    }

    public function getStructures(): ?Structures
    {
        return $this->structures;
    }

    public function setStructures(?Structures $structures): self
    {
        $this->structures = $structures;

        return $this;
    }

    public function getDroits(): ?Droits
    {
        return $this->droits;
    }

    public function setDroits(?Droits $droits): self
    {
        $this->droits = $droits;

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
        $this->franchise = $franchise;

        return $this;
    }

    public function  __toString(): string
    {
      return $this->setDroits();
    }
}
