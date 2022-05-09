<?php

namespace App\Entity;

use App\Repository\BaremeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BaremeRepository::class)
 */
class Bareme
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $grade;

    /**
     * @ORM\Column(type="date")
     */
    private $dateGrade;

    /**
     * @ORM\Column(type="string", length=2)
     */
    private $statut;

    /**
     * @ORM\Column(type="string", length=2)
     */
    private $corps;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $categorie;

    /**
     * @ORM\Column(type="string", length=2)
     */
    private $classe;

    /**
     * @ORM\Column(type="string", length=2)
     */
    private $echelon;

    /**
     * @ORM\Column(type="integer")
     */
    private $indice;

    /**
     * @ORM\Column(type="integer")
     */
    private $salaireBase;

    /**
     * @ORM\Column(type="date")
     */
    private $dateSalaire;

    /**
     * @ORM\Column(type="string", length=4)
     */
    private $numBar;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGrade(): ?string
    {
        return $this->grade;
    }

    public function setGrade(string $grade): self
    {
        $this->grade = $grade;

        return $this;
    }

    public function getDateGrade(): ?\DateTimeInterface
    {
        return $this->dateGrade;
    }

    public function setDateGrade(\DateTimeInterface $dateGrade): self
    {
        $this->dateGrade = $dateGrade;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getCorps(): ?string
    {
        return $this->corps;
    }

    public function setCorps(string $corps): self
    {
        $this->corps = $corps;

        return $this;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getClasse(): ?string
    {
        return $this->classe;
    }

    public function setClasse(string $classe): self
    {
        $this->classe = $classe;

        return $this;
    }

    public function getEchelon(): ?string
    {
        return $this->echelon;
    }

    public function setEchelon(string $echelon): self
    {
        $this->echelon = $echelon;

        return $this;
    }

    public function getIndice(): ?int
    {
        return $this->indice;
    }

    public function setIndice(int $indice): self
    {
        $this->indice = $indice;

        return $this;
    }

    public function getSalaireBase(): ?int
    {
        return $this->salaireBase;
    }

    public function setSalaireBase(int $salaireBase): self
    {
        $this->salaireBase = $salaireBase;

        return $this;
    }

    public function getDateSalaire(): ?\DateTimeInterface
    {
        return $this->dateSalaire;
    }

    public function setDateSalaire(\DateTimeInterface $dateSalaire): self
    {
        $this->dateSalaire = $dateSalaire;

        return $this;
    }

    public function getNumBar(): ?string
    {
        return $this->numBar;
    }

    public function setNumBar(string $numBar): self
    {
        $this->numBar = $numBar;

        return $this;
    }
}
