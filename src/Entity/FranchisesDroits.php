<?php

namespace App\Entity;

use App\Repository\FranchisesDroitsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FranchisesDroitsRepository::class)]
class FranchisesDroits
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'franchisesDroits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Franchises $franchise_id = null;

    #[ORM\ManyToOne(inversedBy: 'franchisesDroits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Droits $droit_id = null;

    #[ORM\Column]
    private ?bool $status = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDroitId(): ?Droits
    {
        return $this->droit_id;
    }

    public function setDroitId(?Droits $droit_id): self
    {
        $this->droit_id = $droit_id;

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
