<?php

namespace App\Entity;

use App\Repository\PaguRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PaguRepository::class)
 */
class Pagu
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pagu;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $range_pagu;

    /**
     * @ORM\OneToMany(targetEntity=DataTraining::class, mappedBy="pagu")
     */
    private $dataTrainings;

    public function __toString() 
    {
        return $this->getRangePagu();
    }

    public function __construct()
    {
        $this->dataTrainings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPagu(): ?string
    {
        return $this->pagu;
    }

    public function setPagu(?string $pagu): self
    {
        $this->pagu = $pagu;

        return $this;
    }

    public function getRangePagu(): ?string
    {
        return $this->range_pagu;
    }

    public function setRangePagu(?string $range_pagu): self
    {
        $this->range_pagu = $range_pagu;

        return $this;
    }

    /**
     * @return Collection<int, DataTraining>
     */
    public function getDataTrainings(): Collection
    {
        return $this->dataTrainings;
    }

    public function addDataTraining(DataTraining $dataTraining): self
    {
        if (!$this->dataTrainings->contains($dataTraining)) {
            $this->dataTrainings[] = $dataTraining;
            $dataTraining->setPagu($this);
        }

        return $this;
    }

    public function removeDataTraining(DataTraining $dataTraining): self
    {
        if ($this->dataTrainings->removeElement($dataTraining)) {
            // set the owning side to null (unless already changed)
            if ($dataTraining->getPagu() === $this) {
                $dataTraining->setPagu(null);
            }
        }

        return $this;
    }
}
