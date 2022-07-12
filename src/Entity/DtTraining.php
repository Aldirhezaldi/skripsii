<?php

namespace App\Entity;

use App\Repository\DtTrainingRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DtTrainingRepository::class)
 */
class DtTraining
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="dt_training_id_seq")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pokja;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $jenis_pengadaan;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sumber_dana;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $jenis_kontrak;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pagu;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPokja(): ?string
    {
        return $this->pokja;
    }

    public function setPokja(?string $pokja): self
    {
        $this->pokja = $pokja;

        return $this;
    }

    public function getJenisPengadaan(): ?string
    {
        return $this->jenis_pengadaan;
    }

    public function setJenisPengadaan(?string $jenis_pengadaan): self
    {
        $this->jenis_pengadaan = $jenis_pengadaan;

        return $this;
    }

    public function getSumberDana(): ?string
    {
        return $this->sumber_dana;
    }

    public function setSumberDana(?string $sumber_dana): self
    {
        $this->sumber_dana = $sumber_dana;

        return $this;
    }

    public function getJenisKontrak(): ?string
    {
        return $this->jenis_kontrak;
    }

    public function setJenisKontrak(?string $jenis_kontrak): self
    {
        $this->jenis_kontrak = $jenis_kontrak;

        return $this;
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
}
