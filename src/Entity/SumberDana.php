<?php

namespace App\Entity;

use App\Repository\SumberDanaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SumberDanaRepository::class)
 */
class SumberDana
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
    private $nama_sumber_dana;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNamaSumberDana(): ?string
    {
        return $this->nama_sumber_dana;
    }

    public function setNamaSumberDana(string $nama_sumber_dana): self
    {
        $this->nama_sumber_dana = $nama_sumber_dana;

        return $this;
    }
}
