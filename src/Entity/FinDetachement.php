<?php

namespace App\Entity;

use App\Repository\FinDetachementRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=FinDetachementRepository::class)
 * @UniqueEntity(fields = "agentDetache",
 *      message = "Ce détachement a déjà pris fin par le passé")
 */
class FinDetachement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $dateFinDet;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $motifFinDet;

    /**
     * @ORM\ManyToOne(targetEntity=AgentDetache::class, inversedBy="finDetachements")
     */
    private $agentDetache;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $refActeFinDet;

    /**
     * @ORM\Column(type="date")
     */
    private $dateSigneActFinDet;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getMotifFinDet(): ?string
    {
        return $this->motifFinDet;
    }

    public function setMotifFinDet(string $motifFinDet): self
    {
        $this->motifFinDet = $motifFinDet;

        return $this;
    }

    public function getAgentDetache(): ?AgentDetache
    {
        return $this->agentDetache;
    }

    public function setAgentDetache(?AgentDetache $agentDetache): self
    {
        $this->agentDetache = $agentDetache;

        return $this;
    }

    public function getRefActeFinDet(): ?string
    {
        return $this->refActeFinDet;
    }

    public function setRefActeFinDet(string $refActeFinDet): self
    {
        $this->refActeFinDet = $refActeFinDet;

        return $this;
    }

    public function getDateSigneActFinDet(): ?\DateTimeInterface
    {
        return $this->dateSigneActFinDet;
    }

    public function setDateSigneActFinDet(\DateTimeInterface $dateSigneActFinDet): self
    {
        $this->dateSigneActFinDet = $dateSigneActFinDet;

        return $this;
    }
}
