<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\OrganismesRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=OrganismesRepository::class)
 * @UniqueEntity(
 *      fields = {"sigle"},
 *      message = "Un autre organisme possède déjà le même sigle, merci de le modifier."
 * )
 */
class Organismes
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelleOrg;

    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    private $region;

    /**
     * @ORM\Column(type="string", length=16, nullable=true)
     */
    private $fax;

    /**
     * @ORM\Column(type="string", length=16, nullable=true)
     * @Assert\Regex(
     *     pattern     = "/^[0-9]{9}/",
     *     match = true,
     *     message="Le numéro de téléphone ne prends que 9 chiffres"
     * )
     */
    private $telephone1;

    /**
     * @ORM\Column(type="string", length=16, nullable=true)
     * @Assert\Regex(
     *     pattern     = "/^[0-9]{9}/",
     *     match = true,
     *     message="Le numéro de téléphone ne prends que 9 chiffres"
     * )
     */
    private $telephone2;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     * @Assert\Email(message = "L'email '{{ value }}' n'est pas valide.")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(
     *     message = "Vous devez obligatoirement renseigner la localité de l'organisme"
     * )
     */
    private $quartier;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $sigle;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $siege;

    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    private $bp;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $siteWeb;

    /**
     * @ORM\OneToMany(targetEntity=Utilisateurs::class, mappedBy="idOrg")
     */
    private $utilisateurs;

    /**
     * @ORM\OneToMany(targetEntity=PointsFocaux::class, mappedBy="idOrg")
     */
    private $pointsFocaux;

    /**
     * @ORM\ManyToMany(targetEntity=AgentDetache::class, mappedBy="organisme")
     */
    private $agentDetaches;

    /**
     * @ORM\OneToMany(targetEntity=Reversement::class, mappedBy="organisme")
     */
    private $reversements;

    public function __construct()
    {
        $this->utilisateurs = new ArrayCollection();
        $this->pointsFocaux = new ArrayCollection();
        $this->agentDetaches = new ArrayCollection();
        $this->reversements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleOrg(): ?string
    {
        return $this->libelleOrg;
    }

    public function setLibelleOrg(string $libelleOrg): self
    {
        $this->libelleOrg = $libelleOrg;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(?string $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getFax(): ?string
    {
        return $this->fax;
    }

    public function setFax(?string $fax): self
    {
        $this->fax = $fax;

        return $this;
    }

    public function getTelephone1(): ?string
    {
        return $this->telephone1;
    }

    public function setTelephone1(?string $telephone1): self
    {
        $this->telephone1 = $telephone1;

        return $this;
    }

    public function getTelephone2(): ?string
    {
        return $this->telephone2;
    }

    public function setTelephone2(?string $telephone2): self
    {
        $this->telephone2 = $telephone2;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getQuartier(): ?string
    {
        return $this->quartier;
    }

    public function setQuartier(?string $quartier): self
    {
        $this->quartier = $quartier;

        return $this;
    }

    public function getSigle(): ?string
    {
        return $this->sigle;
    }

    public function setSigle(string $sigle): self
    {
        $this->sigle = $sigle;

        return $this;
    }

    public function getSiege(): ?string
    {
        return $this->siege;
    }

    public function setSiege(?string $siege): self
    {
        $this->siege = $siege;

        return $this;
    }

    public function getBp(): ?string
    {
        return $this->bp;
    }

    public function setBp(?string $bp): self
    {
        $this->bp = $bp;

        return $this;
    }

    public function getSiteWeb(): ?string
    {
        return $this->siteWeb;
    }

    public function setSiteWeb(?string $siteWeb): self
    {
        $this->siteWeb = $siteWeb;

        return $this;
    }

    /**
     * @return Collection<int, Utilisateurs>
     */
    public function getUtilisateurs(): Collection
    {
        return $this->utilisateurs;
    }

    public function addUtilisateur(Utilisateurs $utilisateur): self
    {
        if (!$this->utilisateurs->contains($utilisateur)) {
            $this->utilisateurs[] = $utilisateur;
            $utilisateur->setIdOrg($this);
        }

        return $this;
    }

    public function removeUtilisateur(Utilisateurs $utilisateur): self
    {
        if ($this->utilisateurs->removeElement($utilisateur)) {
            // set the owning side to null (unless already changed)
            if ($utilisateur->getIdOrg() === $this) {
                $utilisateur->setIdOrg(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PointsFocaux>
     */
    public function getPointsFocaux(): Collection
    {
        return $this->pointsFocaux;
    }

    public function addPointsFocaux(PointsFocaux $pointsFocaux): self
    {
        if (!$this->pointsFocaux->contains($pointsFocaux)) {
            $this->pointsFocaux[] = $pointsFocaux;
            $pointsFocaux->setIdOrg($this);
        }

        return $this;
    }

    public function removePointsFocaux(PointsFocaux $pointsFocaux): self
    {
        if ($this->pointsFocaux->removeElement($pointsFocaux)) {
            // set the owning side to null (unless already changed)
            if ($pointsFocaux->getIdOrg() === $this) {
                $pointsFocaux->setIdOrg(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AgentDetache>
     */
    public function getAgentDetaches(): Collection
    {
        return $this->agentDetaches;
    }

    public function addAgentDetach(AgentDetache $agentDetach): self
    {
        if (!$this->agentDetaches->contains($agentDetach)) {
            $this->agentDetaches[] = $agentDetach;
            $agentDetach->addOrganisme($this);
        }

        return $this;
    }

    public function removeAgentDetach(AgentDetache $agentDetach): self
    {
        if ($this->agentDetaches->removeElement($agentDetach)) {
            $agentDetach->removeOrganisme($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Reversement>
     */
    public function getReversements(): Collection
    {
        return $this->reversements;
    }

    public function addReversement(Reversement $reversement): self
    {
        if (!$this->reversements->contains($reversement)) {
            $this->reversements[] = $reversement;
            $reversement->setOrganisme($this);
        }

        return $this;
    }

    public function removeReversement(Reversement $reversement): self
    {
        if ($this->reversements->removeElement($reversement)) {
            // set the owning side to null (unless already changed)
            if ($reversement->getOrganisme() === $this) {
                $reversement->setOrganisme(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return "(".$this->sigle.") - ".$this->libelleOrg;
    }
}
