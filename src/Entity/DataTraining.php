<?php

namespace App\Entity;

use App\Repository\DataTrainingRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DataTrainingRepository::class)
 */
class DataTraining
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Pokja::class, inversedBy="dataTrainings")
     */
    private $pokja;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $jenis_pengadaan;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sumber_dana;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $jenis_paket;

    /**
     * @ORM\Column(type="integer")
     */
    private $pagu;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPokja(): ?Pokja
    {
        return $this->pokja;
    }

    public function setPokja(?Pokja $pokja): self
    {
        $this->pokja = $pokja;

        return $this;
    }

    public function getJenisPengadaan(): ?string
    {
        return $this->jenis_pengadaan;
    }

    public function setJenisPengadaan(string $jenis_pengadaan): self
    {
        $this->jenis_pengadaan = $jenis_pengadaan;

        return $this;
    }

    public function getSumberDana(): ?string
    {
        return $this->sumber_dana;
    }

    public function setSumberDana(string $sumber_dana): self
    {
        $this->sumber_dana = $sumber_dana;

        return $this;
    }

    public function getJenisPaket(): ?string
    {
        return $this->jenis_paket;
    }

    public function setJenisPaket(string $jenis_paket): self
    {
        $this->jenis_paket = $jenis_paket;

        return $this;
    }

    public function getPagu(): ?int
    {
        return $this->pagu;
    }

    public function setPagu(int $pagu): self
    {
        $this->pagu = $pagu;

        return $this;
    }
}
