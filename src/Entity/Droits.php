<?php

namespace App\Entity;

use App\Repository\DroitsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DroitsRepository::class)]
class Droits
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, minMessage: "Veuillez avoir au moins 3 caractères")]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'droits', targetEntity: StructuresDroits::class)]
    private Collection $structuresDroits;

    public function __construct()
    {
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
            $structuresDroit->setDroits($this);
        }

        return $this;
    }

    public function removeStructuresDroit(StructuresDroits $structuresDroit): self
    {
        if ($this->structuresDroits->removeElement($structuresDroit)) {
            // set the owning side to null (unless already changed)
            if ($structuresDroit->getDroits() === $this) {
                $structuresDroit->setDroits(null);
            }
        }

        return $this;
    }
}
