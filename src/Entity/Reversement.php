<?php

namespace App\Entity;

use App\Repository\ReversementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReversementRepository::class)
 */
class Reversement
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
    private $typeRev;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $refTitre;

    /**
     * @ORM\Column(type="date")
     */
    private $dateTitre;

    /**
     * @ORM\Column(type="integer")
     */
    private $montantRev;

    /**
     * @ORM\Column(type="date")
     */
    private $dateDebRev;

    /**
     * @ORM\Column(type="date")
     */
    private $dateFinRev;

    /**
     * @ORM\ManyToOne(targetEntity=Organismes::class, inversedBy="reversements")
     */
    private $organisme;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $preuveRev;

    /**
     * @ORM\Column(type="date")
     */
    private $dateRev;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateurs::class, inversedBy="reversements")
     */
    private $userRev;

    /**
     * @ORM\OneToMany(targetEntity=Cotisation::class, mappedBy="reversement")
     */
    private $cotisations;

    public function __construct()
    {
        $this->cotisations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeRev(): ?string
    {
        return $this->typeRev;
    }

    public function setTypeRev(string $typeRev): self
    {
        $this->typeRev = $typeRev;

        return $this;
    }

    public function getRefTitre(): ?string
    {
        return $this->refTitre;
    }

    public function setRefTitre(string $refTitre): self
    {
        $this->refTitre = $refTitre;

        return $this;
    }

    public function getDateTitre(): ?\DateTimeInterface
    {
        return $this->dateTitre;
    }

    public function setDateTitre(\DateTimeInterface $dateTitre): self
    {
        $this->dateTitre = $dateTitre;

        return $this;
    }

    public function getMontantRev(): ?int
    {
        return $this->montantRev;
    }

    public function setMontantRev(int $montantRev): self
    {
        $this->montantRev = $montantRev;

        return $this;
    }

    public function getDateDebRev(): ?\DateTimeInterface
    {
        return $this->dateDebRev;
    }

    public function setDateDebRev(\DateTimeInterface $dateDebRev): self
    {
        $this->dateDebRev = $dateDebRev;

        return $this;
    }

    public function getDateFinRev(): ?\DateTimeInterface
    {
        return $this->dateFinRev;
    }

    public function setDateFinRev(\DateTimeInterface $dateFinRev): self
    {
        $this->dateFinRev = $dateFinRev;

        return $this;
    }

    public function getOrganisme(): ?Organismes
    {
        return $this->organisme;
    }

    public function setOrganisme(?Organismes $organisme): self
    {
        $this->organisme = $organisme;

        return $this;
    }

    public function getPreuveRev(): ?string
    {
        return $this->preuveRev;
    }

    public function setPreuveRev(string $preuveRev): self
    {
        $this->preuveRev = $preuveRev;

        return $this;
    }

    public function getDateRev(): ?\DateTimeInterface
    {
        return $this->dateRev;
    }

    public function setDateRev(\DateTimeInterface $dateRev): self
    {
        $this->dateRev = $dateRev;

        return $this;
    }

    public function getUserRev(): ?Utilisateurs
    {
        return $this->userRev;
    }

    public function setUserRev(?Utilisateurs $userRev): self
    {
        $this->userRev = $userRev;

        return $this;
    }

    /**
     * @return Collection<int, Cotisation>
     */
    public function getCotisations(): Collection
    {
        return $this->cotisations;
    }

    public function addCotisation(Cotisation $cotisation): self
    {
        if (!$this->cotisations->contains($cotisation)) {
            $this->cotisations[] = $cotisation;
            $cotisation->setReversement($this);
        }

        return $this;
    }

    public function removeCotisation(Cotisation $cotisation): self
    {
        if ($this->cotisations->removeElement($cotisation)) {
            // set the owning side to null (unless already changed)
            if ($cotisation->getReversement() === $this) {
                $cotisation->setReversement(null);
            }
        }

        return $this;
    }
}
