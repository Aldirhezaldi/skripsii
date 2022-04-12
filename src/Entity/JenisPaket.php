<?php

namespace App\Entity;

use App\Repository\JenisPaketRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=JenisPaketRepository::class)
 */
class JenisPaket
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
    private $nama_jenis_paket;

    /**
     * @ORM\OneToMany(targetEntity=DataTraining::class, mappedBy="jenis_paket")
     */
    private $dataTrainings;

    public function __toString() 
    {
        return $this->getNamaJenisPaket();
    }

    public function __construct()
    {
        $this->dataTrainings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNamaJenisPaket(): ?string
    {
        return $this->nama_jenis_paket;
    }

    public function setNamaJenisPaket(string $nama_jenis_paket): self
    {
        $this->nama_jenis_paket = $nama_jenis_paket;

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
            $dataTraining->setJenisPaket($this);
        }

        return $this;
    }

    public function removeDataTraining(DataTraining $dataTraining): self
    {
        if ($this->dataTrainings->removeElement($dataTraining)) {
            // set the owning side to null (unless already changed)
            if ($dataTraining->getJenisPaket() === $this) {
                $dataTraining->setJenisPaket(null);
            }
        }

        return $this;
    }
}
