<?php

namespace App\Entity;

use App\Repository\CotisationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CotisationRepository::class)
 */
class Cotisation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=AgentDetache::class, inversedBy="cotisations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $agent;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $cotSalariale;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $cotPatronale;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $cotTotale;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $indiceCot;

    /**
     * @ORM\Column(type="date")
     */
    private $dateDebutCot;

    /**
     * @ORM\Column(type="date")
     */
    private $dateFinCot;

    /**
     * @ORM\ManyToOne(targetEntity=Reversement::class, inversedBy="cotisations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $reversement;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCotisation;

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

    public function getCotSalariale(): ?int
    {
        return $this->cotSalariale;
    }

    public function setCotSalariale(?int $cotSalariale): self
    {
        $this->cotSalariale = $cotSalariale;

        return $this;
    }

    public function getCotPatronale(): ?int
    {
        return $this->cotPatronale;
    }

    public function setCotPatronale(?int $cotPatronale): self
    {
        $this->cotPatronale = $cotPatronale;

        return $this;
    }

    public function getCotTotale(): ?int
    {
        return $this->cotTotale;
    }

    public function setCotTotale(?int $cotTotale): self
    {
        $this->cotTotale = $cotTotale;

        return $this;
    }

    public function getIndiceCot(): ?int
    {
        return $this->indiceCot;
    }

    public function setIndiceCot(?int $indiceCot): self
    {
        $this->indiceCot = $indiceCot;

        return $this;
    }

    public function getDateDebutCot(): ?\DateTimeInterface
    {
        return $this->dateDebutCot;
    }

    public function setDateDebutCot(\DateTimeInterface $dateDebutCot): self
    {
        $this->dateDebutCot = $dateDebutCot;

        return $this;
    }

    public function getDateFinCot(): ?\DateTimeInterface
    {
        return $this->dateFinCot;
    }

    public function setDateFinCot(\DateTimeInterface $dateFinCot): self
    {
        $this->dateFinCot = $dateFinCot;

        return $this;
    }

    public function getReversement(): ?Reversement
    {
        return $this->reversement;
    }

    public function setReversement(?Reversement $reversement): self
    {
        $this->reversement = $reversement;

        return $this;
    }

    public function getDateCotisation(): ?\DateTimeInterface
    {
        return $this->dateCotisation;
    }

    public function setDateCotisation(\DateTimeInterface $dateCotisation): self
    {
        $this->dateCotisation = $dateCotisation;

        return $this;
    }
}
