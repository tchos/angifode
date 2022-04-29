<?php

namespace App\Entity;

use App\Repository\PositionGestionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PositionGestionRepository::class)
 */
class PositionGestion
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
    private $codePosgest;

    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    private $libPosgest;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodePosgest(): ?string
    {
        return $this->codePosgest;
    }

    public function setCodePosgest(?string $codePosgest): self
    {
        $this->codePosgest = $codePosgest;

        return $this;
    }

    public function getLibPosgest(): ?string
    {
        return $this->libPosgest;
    }

    public function setLibPosgest(?string $libPosgest): self
    {
        $this->libPosgest = $libPosgest;

        return $this;
    }
}
