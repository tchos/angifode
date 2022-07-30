<?php

namespace App\Entity;

use App\Repository\AgentDetacheRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AgentDetacheRepository::class)
 */
class AgentDetache
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
     * @ORM\Column(type="date")
     */
    private $dateNaissance;

    /**
     * @ORM\Column(type="date")
     */
    private $dateIntegration;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $refActeInt;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $gradeDet;

    /**
     * @ORM\Column(type="string", length=2)
     */
    private $echelonDet;

    /**
     * @ORM\Column(type="string", length=2)
     */
    private $classeDet;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $refActeDet;

    /**
     * @ORM\Column(type="date")
     */
    private $dateDet;

    /**
     * @ORM\Column(type="date")
     */
    private $dateSuspension;

    /**
     * @ORM\Column(type="date")
     */
    private $datePriseService;

    /**
     * @ORM\Column(type="string", length=2)
     */
    private $ministere;

    /**
     * @ORM\Column(type="date")
     */
    private $dateFinDet;

    /**
     * @ORM\Column(type="date")
     */
    private $dateCreation;

    /**
     * @ORM\ManyToMany(targetEntity=Organismes::class, inversedBy="agentDetaches")
     */
    private $organisme;

    /**
     * @ORM\OneToMany(targetEntity=Cotisation::class, mappedBy="agent")
     */
    private $cotisations;

    /**
     * @ORM\OneToMany(targetEntity=Avancement::class, mappedBy="agent")
     */
    private $avancements;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $typeActe;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $typeActeDet;

    /**
     * @ORM\Column(type="date")
     */
    private $dateActeDet;

    public function __construct()
    {
        $this->organisme = new ArrayCollection();
        $this->cotisations = new ArrayCollection();
        $this->avancements = new ArrayCollection();
    }

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

    public function setDateNaissance(\DateTimeInterface $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getDateIntegration(): ?\DateTimeInterface
    {
        return $this->dateIntegration;
    }

    public function setDateIntegration(\DateTimeInterface $dateIntegration): self
    {
        $this->dateIntegration = $dateIntegration;

        return $this;
    }

    public function getRefActeInt(): ?string
    {
        return $this->refActeInt;
    }

    public function setRefActeInt(?string $refActeInt): self
    {
        $this->refActeInt = $refActeInt;

        return $this;
    }

    public function getGradeDet(): ?string
    {
        return $this->gradeDet;
    }

    public function setGradeDet(string $gradeDet): self
    {
        $this->gradeDet = $gradeDet;

        return $this;
    }

    public function getEchelonDet(): ?string
    {
        return $this->echelonDet;
    }

    public function setEchelonDet(string $echelonDet): self
    {
        $this->echelonDet = $echelonDet;

        return $this;
    }

    public function getClasseDet(): ?string
    {
        return $this->classeDet;
    }

    public function setClasseDet(string $classeDet): self
    {
        $this->classeDet = $classeDet;

        return $this;
    }

    public function getRefActeDet(): ?string
    {
        return $this->refActeDet;
    }

    public function setRefActeDet(string $refActeDet): self
    {
        $this->refActeDet = $refActeDet;

        return $this;
    }

    public function getDateDet(): ?\DateTimeInterface
    {
        return $this->dateDet;
    }

    public function setDateDet(\DateTimeInterface $dateDet): self
    {
        $this->dateDet = $dateDet;

        return $this;
    }

    public function getDateSuspension(): ?\DateTimeInterface
    {
        return $this->dateSuspension;
    }

    public function setDateSuspension(\DateTimeInterface $dateSuspension): self
    {
        $this->dateSuspension = $dateSuspension;

        return $this;
    }

    public function getDatePriseService(): ?\DateTimeInterface
    {
        return $this->datePriseService;
    }

    public function setDatePriseService(\DateTimeInterface $datePriseService): self
    {
        $this->datePriseService = $datePriseService;

        return $this;
    }

    public function getMinistere(): ?string
    {
        return $this->ministere;
    }

    public function setMinistere(string $ministere): self
    {
        $this->ministere = $ministere;

        return $this;
    }

    public function getDateFinDet(): ?\DateTimeInterface
    {
        return $this->dateFinDet;
    }

    public function setDateFinDet(\DateTimeInterface $dateFinDet): self
    {
        $this->dateFinDet = $dateFinDet;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * @return Collection<int, Organismes>
     */
    public function getOrganisme(): Collection
    {
        return $this->organisme;
    }

    public function addOrganisme(Organismes $organisme): self
    {
        if (!$this->organisme->contains($organisme)) {
            $this->organisme[] = $organisme;
        }

        return $this;
    }

    public function removeOrganisme(Organismes $organisme): self
    {
        $this->organisme->removeElement($organisme);

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
            $cotisation->setAgent($this);
        }

        return $this;
    }

    public function removeCotisation(Cotisation $cotisation): self
    {
        if ($this->cotisations->removeElement($cotisation)) {
            // set the owning side to null (unless already changed)
            if ($cotisation->getAgent() === $this) {
                $cotisation->setAgent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Avancement>
     */
    public function getAvancements(): Collection
    {
        return $this->avancements;
    }

    public function addAvancement(Avancement $avancement): self
    {
        if (!$this->avancements->contains($avancement)) {
            $this->avancements[] = $avancement;
            $avancement->setAgent($this);
        }

        return $this;
    }

    public function removeAvancement(Avancement $avancement): self
    {
        if ($this->avancements->removeElement($avancement)) {
            // set the owning side to null (unless already changed)
            if ($avancement->getAgent() === $this) {
                $avancement->setAgent(null);
            }
        }

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getTypeActe(): ?string
    {
        return $this->typeActe;
    }

    public function setTypeActe(string $typeActe): self
    {
        $this->typeActe = $typeActe;

        return $this;
    }

    public function getTypeActeDet(): ?string
    {
        return $this->typeActeDet;
    }

    public function setTypeActeDet(string $typeActeDet): self
    {
        $this->typeActeDet = $typeActeDet;

        return $this;
    }

    public function getDateActeDet(): ?\DateTimeInterface
    {
        return $this->dateActeDet;
    }

    public function setDateActeDet(\DateTimeInterface $dateActeDet): self
    {
        $this->dateActeDet = $dateActeDet;

        return $this;
    }
}
