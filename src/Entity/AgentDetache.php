<?php

namespace App\Entity;

use App\Repository\AgentDetacheRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=AgentDetacheRepository::class)
 * @UniqueEntity(fields = {"matricule","organisme"},
 *      message = "Agent dejà détaché dans la même structure")
 * @ORM\HasLifecycleCallbacks
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
     * @Assert\Regex(
     *      pattern="/(^[A-Z][0-9]{6}$)|(^[0-9]{5,6}[A-Z]$)/",
     *      message="Le matricule {{ value }} n'est pas un matricule valide.")
     */
    private $matricule;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 3,
     *      max = 64,
     *      minMessage = "Le nom doit avoir au minimum {{ limit }} caractères",
     *      maxMessage = "Le nom doit avoir au maximum {{ limit }} caractères"
     * )
     * @Assert\Regex (
     *     pattern="/^([A-Z\s0-9\-])*$/",
     *     message="Le nom doit être en majuscule")
     */
    private $noms;

    /**
     * @ORM\Column(type="date")
     * @Assert\LessThan(propertyPath="dateIntegration",
     *  message="La date de naissance ne peut être postérieure à la date d'intégration !")
     * @Assert\LessThanOrEqual ("-18 years", message="L'agent ne peut avoir moins de 18 ans")
     */
    private $dateNaissance;

    /**
     * @ORM\Column(type="date")
     * @Assert\LessThanOrEqual(propertyPath="dateDet",
     *  message="La date d'intégration ne peut être postérieure à la date de détachement !")
     */
    private $dateIntegration;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Regex (pattern="/[A-Z0-9\/]+/", message="Mauvais format de la référence")
     * @Assert\Expression ("this.getRefActeDet() != this.getRefActeInt()",
     *     message="La référence d'intégration doit être de la référence de détachement")
     */
    private $refActeInt;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $gradeDet;

    /**
     * @ORM\Column(type="string", length=2)
     * @Assert\Regex (
     *     pattern="/0[0-9]{1}|1[0-2]/",
     *     message="Les échelons vont de 00 à 12")
     */
    private $echelonDet;

    /**
     * @ORM\Column(type="string", length=2)
     * @Assert\Regex (
     *     pattern="/[0-2EH]/",
     *     message="0 à 2 ou E ou H")
     */
    private $classeDet;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex (
     *     pattern="/[A-Z0-9\/]+/",
     *     message="Mauvais format de la référence")
     * @Assert\Expression ("this.getRefActeDet() != this.getRefActeInt()",
     *     message="La référence d'intégration doit être de la référence de détachement")
     */
    private $refActeDet;

    /**
     * @ORM\Column(type="date")
     */
    private $dateDet;

    /**
     * @ORM\Column(type="date")
     * @Assert\GreaterThan(propertyPath="dateDet",
     *  message="La date de suspension ne peut être antérieure à la date de détachement !")
     */
    private $dateSuspension;

    /**
     * @ORM\Column(type="date")
     * @Assert\GreaterThan(propertyPath="dateDet",
     *  message="La date de prise de service ne peut être antérieure à la date de détachement !")
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
    private $typeActeDet;

    /**
     * @ORM\Column(type="date")
     * @Assert\GreaterThanOrEqual(propertyPath="dateDet",
     *  message="La date de signature de l'acte de détachement ne peut être antérieure à la date de détachement !")
     */
    private $dateActeDet;

    /**
     * @ORM\ManyToOne(targetEntity=Organismes::class, inversedBy="agentDetaches")
     * @ORM\JoinColumn(nullable=false)
     */
    private $organisme;

    /**
     * @ORM\OneToMany(targetEntity=FinDetachement::class, mappedBy="agentDetache")
     */
    private $finDetachements;

    /**
     * CallBack appelé à chaque fois que l'on veut enregistrer un agent détaché pour
     * calculer sa date de saisie et sa date de fin détachement. *
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     *
     * @return void
     */
    public function PrePersist()
    {
        if (empty($this->dateCreation)) {
            $this->dateCreation = new \DateTime();
        }
        /** Par défaut la date de fin de détachement à
         * l'enregistrement sera sous la forme 0000-00-00
         * */
        if (empty($this->dateFinDet)) {
            $this->dateFinDet = new \DateTime(date("01/01/0001"));
        }
    }

    public function __construct()
    {
        $this->cotisations = new ArrayCollection();
        $this->avancements = new ArrayCollection();
        $this->finDetachements = new ArrayCollection();
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

    public function getOrganisme(): ?Organismes
    {
        return $this->organisme;
    }

    public function setOrganisme(?Organismes $organisme): self
    {
        $this->organisme = $organisme;

        return $this;
    }

    /**
     * Fonction toString(): renvoie le matricule et le nom de l'agent détaché
     */
    public function __toString()
    {
        // TODO: Implement __toString() method.
        $resultat = $this->noms . "(" . $this->matricule . ") ";
        return $resultat;
    }

    /**
     * @return Collection<int, FinDetachement>
     */
    public function getFinDetachements(): Collection
    {
        return $this->finDetachements;
    }

    public function addFinDetachement(FinDetachement $finDetachement): self
    {
        if (!$this->finDetachements->contains($finDetachement)) {
            $this->finDetachements[] = $finDetachement;
            $finDetachement->setAgentDetache($this);
        }

        return $this;
    }

    public function removeFinDetachement(FinDetachement $finDetachement): self
    {
        if ($this->finDetachements->removeElement($finDetachement)) {
            // set the owning side to null (unless already changed)
            if ($finDetachement->getAgentDetache() === $this) {
                $finDetachement->setAgentDetache(null);
            }
        }

        return $this;
    }
}
