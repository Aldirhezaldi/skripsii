<?php

namespace App\Entity;

use App\Repository\DtTestingRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DtTestingRepository::class)
 */
class DtTesting
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=JenisPengadaan::class, inversedBy="dtTestings")
     */
    private $jenis_pengadaan;

    /**
     * @ORM\ManyToOne(targetEntity=SumberDana::class, inversedBy="dtTestings")
     */
    private $sumber_dana;

    /**
     * @ORM\ManyToOne(targetEntity=JenisKontrak::class, inversedBy="dtTestings")
     */
    private $jenis_kontrak;

    /**
     * @ORM\ManyToOne(targetEntity=Pagu::class, inversedBy="dtTestings")
     */
    private $pagu;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getJenisKontrak(): ?JenisKontrak
    {
        return $this->jenis_kontrak;
    }

    public function setJenisKontrak(?JenisKontrak $jenis_kontrak): self
    {
        $this->jenis_kontrak = $jenis_kontrak;

        return $this;
    }

    public function getPagu(): ?Pagu
    {
        return $this->pagu;
    }

    public function setPagu(?Pagu $pagu): self
    {
        $this->pagu = $pagu;

        return $this;
    }

}
