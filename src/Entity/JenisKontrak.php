<?php

namespace App\Entity;

use App\Repository\JenisKontrakRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=JenisKontrakRepository::class)
 */
class JenisKontrak
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
    private $nama_jenis_kontrak;

    /**
     * @ORM\OneToMany(targetEntity=DataTraining::class, mappedBy="jenis_kontrak")
     */
    private $dataTrainings;

    /**
     * @ORM\OneToMany(targetEntity=DtTesting::class, mappedBy="jenis_kontrak")
     */
    private $dtTestings;

    public function __toString() 
    {
        return $this->getNamaJenisKontrak();
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

    public function getNamaJenisKontrak(): ?string
    {
        return $this->nama_jenis_kontrak;
    }

    public function setNamaJenisKontrak(string $nama_jenis_kontrak): self
    {
        $this->nama_jenis_kontrak = $nama_jenis_kontrak;

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
            $dataTraining->setJenisKontrak($this);
        }

        return $this;
    }

    public function removeDataTraining(DataTraining $dataTraining): self
    {
        if ($this->dataTrainings->removeElement($dataTraining)) {
            // set the owning side to null (unless already changed)
            if ($dataTraining->getJenisKontrak() === $this) {
                $dataTraining->setJenisKontrak(null);
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
            $dtTesting->setJenisKontrak($this);
        }

        return $this;
    }

    public function removeDtTesting(DtTesting $dtTesting): self
    {
        if ($this->dtTestings->removeElement($dtTesting)) {
            // set the owning side to null (unless already changed)
            if ($dtTesting->getJenisKontrak() === $this) {
                $dtTesting->setJenisKontrak(null);
            }
        }

        return $this;
    }
}
