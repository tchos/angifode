<?php

namespace App\Entity;

use App\Repository\HistoriqueRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HistoriqueRepository::class)
 */
class Historique
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $typeAction;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $nature;

    /**
     * @ORM\Column(type="string", length=8)
     */
    private $clef;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $auteur;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateAction;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeAction(): ?string
    {
        return $this->typeAction;
    }

    public function setTypeAction(string $typeAction): self
    {
        $this->typeAction = $typeAction;

        return $this;
    }

    public function getNature(): ?string
    {
        return $this->nature;
    }

    public function setNature(string $nature): self
    {
        $this->nature = $nature;

        return $this;
    }

    public function getClef(): ?string
    {
        return $this->clef;
    }

    public function setClef(string $clef): self
    {
        $this->clef = $clef;

        return $this;
    }

    public function getAuteur(): ?string
    {
        return $this->auteur;
    }

    public function setAuteur(string $auteur): self
    {
        $this->auteur = $auteur;

        return $this;
    }

    public function getDateAction(): ?\DateTimeInterface
    {
        return $this->dateAction;
    }

    public function setDateAction(\DateTimeInterface $dateAction): self
    {
        $this->dateAction = $dateAction;

        return $this;
    }
}
