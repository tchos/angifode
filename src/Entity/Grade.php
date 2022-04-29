<?php

namespace App\Entity;

use App\Repository\GradeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GradeRepository::class)
 */
class Grade
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
    private $codeGrade;

    /**
     * @ORM\Column(type="string", length=128)
     */
    private $libGrade;

    /**
     * @ORM\Column(type="string", length=2, nullable=true)
     */
    private $statut;

    /**
     * @ORM\Column(type="string", length=2, nullable=true)
     */
    private $corps;

    /**
     * @ORM\Column(type="string", length=2, nullable=true)
     */
    private $cadre;

    /**
     * @ORM\Column(type="string", length=5, nullable=true)
     */
    private $categorie;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodeGrade(): ?string
    {
        return $this->codeGrade;
    }

    public function setCodeGrade(string $codeGrade): self
    {
        $this->codeGrade = $codeGrade;

        return $this;
    }

    public function getLibGrade(): ?string
    {
        return $this->libGrade;
    }

    public function setLibGrade(string $libGrade): self
    {
        $this->libGrade = $libGrade;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(?string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getCorps(): ?string
    {
        return $this->corps;
    }

    public function setCorps(?string $corps): self
    {
        $this->corps = $corps;

        return $this;
    }

    public function getCadre(): ?string
    {
        return $this->cadre;
    }

    public function setCadre(?string $cadre): self
    {
        $this->cadre = $cadre;

        return $this;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(?string $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }
}
