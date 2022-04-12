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
     * @ORM\ManyToOne(targetEntity=JenisPengadaan::class, inversedBy="dataTrainings")
     */
    private $jenis_pengadaan;

    /**
     * @ORM\ManyToOne(targetEntity=SumberDana::class, inversedBy="dataTrainings")
     */
    private $sumber_dana;

    /**
     * @ORM\ManyToOne(targetEntity=JenisPaket::class, inversedBy="dataTrainings")
     */
    private $jenis_paket;

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

    public function getJenisPengadaan(): ?JenisPengadaan
    {
        return $this->jenis_pengadaan;
    }

    public function setJenisPengadaan(?JenisPengadaan $jenis_pengadaan): self
    {
        $this->jenis_pengadaan = $jenis_pengadaan;

        return $this;
    }

    public function getSumberDana(): ?SumberDana
    {
        return $this->sumber_dana;
    }

    public function setSumberDana(?SumberDana $sumber_dana): self
    {
        $this->sumber_dana = $sumber_dana;

        return $this;
    }

    public function getJenisPaket(): ?JenisPaket
    {
        return $this->jenis_paket;
    }

    public function setJenisPaket(?JenisPaket $jenis_paket): self
    {
        $this->jenis_paket = $jenis_paket;

        return $this;
    }
}