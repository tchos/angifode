<?php

namespace App\Entity;

use App\Repository\MinistereRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MinistereRepository::class)
 */
class Ministere
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=2, nullable=true)
     */
    private $codeMinistere;

    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    private $abrvMinistere;

    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    private $libMinistere;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodeMinistere(): ?string
    {
        return $this->codeMinistere;
    }

    public function setCodeMinistere(?string $codeMinistere): self
    {
        $this->codeMinistere = $codeMinistere;

        return $this;
    }

    public function getAbrvMinistere(): ?string
    {
        return $this->abrvMinistere;
    }

    public function setAbrvMinistere(?string $abrvMinistere): self
    {
        $this->abrvMinistere = $abrvMinistere;

        return $this;
    }

    public function getLibMinistere(): ?string
    {
        return $this->libMinistere;
    }

    public function setLibMinistere(?string $libMinistere): self
    {
        $this->libMinistere = $libMinistere;

        return $this;
    }
}
