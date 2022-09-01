<?php

namespace App\Entity;

use App\Repository\StructuresDroitsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StructuresDroitsRepository::class)]
class StructuresDroits
{
    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'structuresDroits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Structures $structures = null;
  
    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'structuresDroits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Droits $droits = null;

    #[ORM\Column]
    private ?bool $status = null;

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
}
