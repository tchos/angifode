<?php

namespace App\Entity;

use App\Repository\AgentsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AgentsRepository::class)
 */
class Agents
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=7)
     */
    private $matricule;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $noms;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateNaissance;

    /**
     * @ORM\Column(type="string", length=1, nullable=true)
     */
    private $sexe;

    /**
     * @ORM\Column(type="string", length=5, nullable=true)
     */
    private $grade;

    /**
     * @ORM\Column(type="string", length=2, nullable=true)
     */
    private $ministere;

    /**
     * @ORM\Column(type="string", length=2, nullable=true)
     */
    private $posGest;

    /**
     * @ORM\Column(type="string", length=2, nullable=true)
     */
    private $posSold;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nap;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(string $matricule): self
    {
        $this->matricule = $matricule;

        return $this;
    }

    public function getNoms(): ?string
    {
        return $this->noms;
    }

    public function setNoms(string $noms): self
    {
        $this->noms = $noms;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(?\DateTimeInterface $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(?string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getGrade(): ?string
    {
        return $this->grade;
    }

    public function setGrade(?string $grade): self
    {
        $this->grade = $grade;

        return $this;
    }

    public function getMinistere(): ?string
    {
        return $this->ministere;
    }

    public function setMinistere(?string $ministere): self
    {
        $this->ministere = $ministere;

        return $this;
    }

    public function getPosGest(): ?string
    {
        return $this->posGest;
    }

    public function setPosGest(?string $posGest): self
    {
        $this->posGest = $posGest;

        return $this;
    }

    public function getPosSold(): ?string
    {
        return $this->posSold;
    }

    public function setPosSold(?string $posSold): self
    {
        $this->posSold = $posSold;

        return $this;
    }

    public function getNap(): ?int
    {
        return $this->nap;
    }

    public function setNap(?int $nap): self
    {
        $this->nap = $nap;

        return $this;
    }
}
