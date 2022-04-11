<?php

namespace App\Entity;

use App\Repository\JenisPengadaanRepository;
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
}
