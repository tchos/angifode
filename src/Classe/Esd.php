<?php

namespace App\Classe;

use Symfony\Component\Validator\Constraints as Assert;

class Esd
{
    /**
     * @var dateDebut
     */
    private $dateDebut;

    /**
     * @var dateFin
     * @Assert\GreaterThan(propertyPath="dateDebut", message="La date de début doit être antérieure à la date de fin !!!")
     */
    private $dateFin;

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): void
    {
        $this->dateDebut = $dateDebut;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): void
    {
        $this->dateFin = $dateFin;
    }
}