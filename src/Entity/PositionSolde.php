<?php

namespace App\Entity;

use App\Repository\PositionSoldeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PositionSoldeRepository::class)
 */
class PositionSolde
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
    private $codePossold;

    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    private $libPossold;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodePossold(): ?string
    {
        return $this->codePossold;
    }

    public function setCodePossold(?string $codePossold): self
    {
        $this->codePossold = $codePossold;

        return $this;
    }

    public function getLibPossold(): ?string
    {
        return $this->libPossold;
    }

    public function setLibPossold(?string $libPossold): self
    {
        $this->libPossold = $libPossold;

        return $this;
    }
}
