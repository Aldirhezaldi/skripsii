<?php

namespace App\Entity;

use App\Repository\JenisPengadaanRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=JenisPengadaanRepository::class)
 */
class JenisPengadaan
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
    private $nama_jenis_pengadaan;

    /**
     * @ORM\OneToMany(targetEntity=DataTraining::class, mappedBy="jenis_pengadaan")
     */
    private $dataTrainings;

    /**
     * @ORM\OneToMany(targetEntity=DtTesting::class, mappedBy="jenis_pengadaan")
     */
    private $dtTestings;

    public function __toString() 
    {
        return $this->getNamaJenisPengadaan();
    }

    public function __construct()
    {
        $this->dataTrainings = new ArrayCollection();
        $this->dtTestings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNamaJenisPengadaan(): ?string
    {
        return $this->nama_jenis_pengadaan;
    }

    public function setNamaJenisPengadaan(string $nama_jenis_pengadaan): self
    {
        $this->nama_jenis_pengadaan = $nama_jenis_pengadaan;

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
            $dataTraining->setJenisPengadaan($this);
        }

        return $this;
    }

    public function removeDataTraining(DataTraining $dataTraining): self
    {
        if ($this->dataTrainings->removeElement($dataTraining)) {
            // set the owning side to null (unless already changed)
            if ($dataTraining->getJenisPengadaan() === $this) {
                $dataTraining->setJenisPengadaan(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, DtTesting>
     */
    public function getDtTestings(): Collection
    {
        return $this->dtTestings;
    }

    public function addDtTesting(DtTesting $dtTesting): self
    {
        if (!$this->dtTestings->contains($dtTesting)) {
            $this->dtTestings[] = $dtTesting;
            $dtTesting->setJenisPengadaan($this);
        }

        return $this;
    }

    public function removeDtTesting(DtTesting $dtTesting): self
    {
        if ($this->dtTestings->removeElement($dtTesting)) {
            // set the owning side to null (unless already changed)
            if ($dtTesting->getJenisPengadaan() === $this) {
                $dtTesting->setJenisPengadaan(null);
            }
        }

        return $this;
    }
}
