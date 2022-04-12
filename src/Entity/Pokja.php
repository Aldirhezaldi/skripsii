<?php

namespace App\Entity;

use App\Repository\PokjaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PokjaRepository::class)
 */
class Pokja
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
    private $nama_pokja;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $surat_keputusan;

    /**
     * @ORM\Column(type="date")
     */
    private $tanggal_sk;

    /**
     * @ORM\OneToMany(targetEntity=DataTraining::class, mappedBy="pokja")
     */
    private $dataTrainings;

    public function __toString() 
    {
        return $this->getNamaPokja();
    }
    
    public function __construct()
    {
        $this->dataTrainings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNamaPokja(): ?string
    {
        return $this->nama_pokja;
    }

    public function setNamaPokja(string $nama_pokja): self
    {
        $this->nama_pokja = $nama_pokja;

        return $this;
    }

    public function getSuratKeputusan(): ?string
    {
        return $this->surat_keputusan;
    }

    public function setSuratKeputusan(string $surat_keputusan): self
    {
        $this->surat_keputusan = $surat_keputusan;

        return $this;
    }

    public function getTanggalSk(): ?\DateTimeInterface
    {
        return $this->tanggal_sk;
    }

    public function setTanggalSk(\DateTimeInterface $tanggal_sk): self
    {
        $this->tanggal_sk = $tanggal_sk;

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
            $dataTraining->setPokja($this);
        }

        return $this;
    }

    public function removeDataTraining(DataTraining $dataTraining): self
    {
        if ($this->dataTrainings->removeElement($dataTraining)) {
            // set the owning side to null (unless already changed)
            if ($dataTraining->getPokja() === $this) {
                $dataTraining->setPokja(null);
            }
        }

        return $this;
    }
}
