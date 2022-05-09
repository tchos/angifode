<?php

namespace App\Entity;

use App\Repository\AvancementRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AvancementRepository::class)
 */
class Avancement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=AgentDetache::class, inversedBy="avancements")
     * @ORM\JoinColumn(nullable=false)
     */
    private $agent;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $categorie;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $grade;

    /**
     * @ORM\Column(type="string", length=2)
     */
    private $echelon;

    /**
     * @ORM\Column(type="integer")
     */
    private $indice;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $refActe;

    /**
     * @ORM\Column(type="date")
     */
    private $dateEffet;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $typeMaj;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAgent(): ?AgentDetache
    {
        return $this->agent;
    }

    public function setAgent(?AgentDetache $agent): self
    {
        $this->agent = $agent;

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

    public function getGrade(): ?string
    {
        return $this->grade;
    }

    public function setGrade(string $grade): self
    {
        $this->grade = $grade;

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

    public function getRefActe(): ?string
    {
        return $this->refActe;
    }

    public function setRefActe(string $refActe): self
    {
        $this->refActe = $refActe;

        return $this;
    }

    public function getDateEffet(): ?\DateTimeInterface
    {
        return $this->dateEffet;
    }

    public function setDateEffet(\DateTimeInterface $dateEffet): self
    {
        $this->dateEffet = $dateEffet;

        return $this;
    }

    public function getTypeMaj(): ?string
    {
        return $this->typeMaj;
    }

    public function setTypeMaj(string $typeMaj): self
    {
        $this->typeMaj = $typeMaj;

        return $this;
    }
}
