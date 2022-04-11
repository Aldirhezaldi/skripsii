<?php

namespace App\Entity;

use App\Repository\JenisPaketRepository;
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
}
