<?php

namespace App\Entity;

use App\Repository\SumberDanaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SumberDanaRepository::class)
 */
class SumberDana
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nama_sumber_dana;

    /**
     * @ORM\OneToMany(targetEntity=DataTraining::class, mappedBy="sumber_dana")
     */
    private $dataTrainings;

    public function __toString() 
    {
        return (string)$this->getNamaSumberDana();
    }

    public function __construct()
    {
        $this->dataTrainings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNamaSumberDana(): ?string
    {
        return $this->nama_sumber_dana;
    }

    public function setNamaSumberDana(string $nama_sumber_dana): self
    {
        $this->nama_sumber_dana = $nama_sumber_dana;

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
            $dataTraining->setSumberDana($this);
        }

        return $this;
    }

    public function removeDataTraining(DataTraining $dataTraining): self
    {
        if ($this->dataTrainings->removeElement($dataTraining)) {
            // set the owning side to null (unless already changed)
            if ($dataTraining->getSumberDana() === $this) {
                $dataTraining->setSumberDana(null);
            }
        }

        return $this;
    }
}
