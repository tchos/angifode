<?php

namespace App\Services;

use App\Entity\AgentDetache;
use App\Entity\Bareme;
use App\Repository\BaremeRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Integer;

class Services
{
    private $manager;
    private $reposBareme;

    public function __construct(EntityManagerInterface $manager, BaremeRepository $reposBareme)
    {
        $this->manager = $manager;
        $this->reposBareme = $reposBareme;
    }

    public function getStats()
    {
        $nbUsers = $this->getUsersCount();
        $nbOrganismes = $this->getOrganismesCount();
        $nbAgentsDetaches = $this->getAgentsDetachesCount();

        return compact('nbUsers', 'nbOrganismes', 'nbAgentsDetaches');
    }

    /**
     * Retourne le nombre de users inscrits
     *
     * @return Integer
     */
    public function getUsersCount()
    {
        return $this->manager->createQuery('SELECT COUNT(u) FROM App\Entity\User u')->getSingleScalarResult();
    }

    /**
     * Retourne le nombre d'organismes parapublics
     *
     * @return Integer
     */
    public function getOrganismesCount()
    {
        return $this->manager->createQuery('SELECT COUNT(o) FROM App\Entity\Organismes o')
            ->getSingleScalarResult();
    }

    /**
     * Retourne le nombre d'agents détachés
     *
     * @return Integer
     */
    public function getAgentsDetachesCount()
    {
        return $this->manager->createQuery('SELECT COUNT(a) FROM App\Entity\AgentDetache a')
            ->getSingleScalarResult();
    }

    /**
     * Retourne la liste des agents pour lesquels on a pas encore cotisé
     */
    public function getListeACotiser($reversement)
    {
        //Liste des agants pour lesquels on n'a pas encore cotisé
        $agentsNonCotiser = $this->manager->createQuery(
            "SELECT a.id, CONCAT(a.noms,' - (', a.matricule,')') as nom
                FROM App\Entity\AgentDetache a
                WHERE a.id NOT IN ( SELECT ad.id
                                FROM App\Entity\Cotisation c
                                JOIN c.agent ad
                                JOIN c.reversement r
                                WHERE r = :reversement )
                ORDER BY nom"
        )
            ->setParameter('reversement', $reversement)
            ->getResult();

        $anc = [];
        foreach ($agentsNonCotiser as $i => $val) {
            $anc[$agentsNonCotiser[$i]['nom']] = $agentsNonCotiser[$i]['id'];
        }
        return $anc;
    }

    /**
     * @return Bareme Returns an array of Bareme objects
     */
    public function dateSalaire($dateDebut, $dateFin) {

        //Liste des agants pour lesquels on n'a pas encore cotisé
        return $this->manager->createQuery(
            "SELECT DISTINCT(b.dateSalaire)
                FROM App\Entity\Bareme b
                WHERE b.numBar IN ( SELECT t.numBar
                                FROM App\Entity\TypeBareme t
                                WHERE t.dateDebut <= :dateFin AND t.dateFin >= :dateDebut )
            "
        )
            ->setParameter('dateDebut', $dateDebut)
            ->setParameter('dateFin', $dateFin)
            ->getResult();
    }

    /**
     * Retourne les sommes à reverser pour un agent détaché
     * @Return array
     */
    public function getPeriodes($dateDebut, $dateFin){

        // Dates barème
        $bareme = $this->dateSalaire($dateDebut, $dateFin);

        // Va contenir toutes les périodes de détachement
        $tableauPeriode = [];

        // Date de début
        $tableauPeriode[] = date_format($dateDebut, 'Y-m-d');
        $tableauPeriode[] = date_format($dateFin, 'Y-m-d');
        foreach ($bareme as $keys => $value) {
            foreach ($value as $key => $date) {
                if ($dateDebut <= date_create($date) && date_create($date) <= $dateFin)
                    $tableauPeriode[] = date('Y-m-d', strtotime($date));
            }
        }

        // prochain avancement
        $dateIntegration = date_create("1995-11-01");
        date_add($dateIntegration,date_interval_create_from_date_string("2 years"));

        while ($dateIntegration <= $dateFin) {
            if ($dateDebut <= $dateIntegration && $dateIntegration <= $dateFin) {
                $tableauPeriode[] = date_format($dateIntegration, 'Y-m-d');
            }

            date_add($dateIntegration,date_interval_create_from_date_string("2 years"));
        }


        // Tri du tableau
        sort($tableauPeriode);

        return $tableauPeriode;
    }

    /**
     * Retourne le salaire de base sur une période
     * @return Integer
     */
    public function getSalaire($dateDebut, $dateFin, $grade, $classe, $echelon) {

        //select salaire_base from bareme where grade="42210" AND classe="2" AND echelon="01"
        // AND num_bar IN (select num_bar from type_bareme where date_debut <= "2003-09-01" and date_fin >= "2002-02-11");
        //Liste des agants pour lesquels on n'a pas encore cotisé
        return $this->manager->createQuery(
            "SELECT b.salaireBase
                FROM App\Entity\Bareme b
                WHERE b.grade = :grade AND b.classe = :classe AND b.echelon = :echelon AND b.numBar IN ( 
                    SELECT t.numBar
                    FROM App\Entity\TypeBareme t
                    WHERE t.dateDebut <= :dateFin AND t.dateFin >= :dateDebut )
            "
        )
        ->setParameter('dateDebut', $dateDebut)
        ->setParameter('dateFin', $dateFin)
        ->setParameter('grade', $grade)
        ->setParameter('classe', $classe)
        ->setParameter('echelon', $echelon)
        ->getSingleScalarResult();
    }

    /**
     * Retourne la somme à reverser sur une période de date
     * @Return Integer
     */
    public function getSommeAReverser($dateDebut, $dateFin, $typeAgent) {
        $sar = 0;
        $tableauPeriode = $this->getPeriodes($dateDebut, $dateFin);

        $dateDebut = date_create($tableauPeriode[0]);
        $dateFin = date_create($tableauPeriode[1]);
        date_sub($dateFin,date_interval_create_from_date_string("1 day"));

        $sb = $this->getSalaire($dateDebut, $dateFin, "42210", "2", "01");

        $pd = $dateDebut->diff($dateFin)->format('%d');

        if ($typeAgent == 1) {
            $sar = $sar + (($sb * 12 * 22 * $pd) / (360 * 100));
        } else {
            $sar = $sar + (($sb * 12 * 18 * $pd) / (360 * 100));
        }

        for ($i = 4; $i < count($tableauPeriode); $i++) {

            $dateDebut = date_create($tableauPeriode[$i]);
            $dateFin = date_create($tableauPeriode[$i+1]);
            date_sub($dateFin,date_interval_create_from_date_string("1 day"));
            dd($dateDebut, $dateFin);
            $sb = $this->getSalaire($dateDebut, $dateFin, "42210", "2", "01");
            dd($sb);
            $pd = $dateDebut->diff($dateFin)->days;

            if ($typeAgent == 1) {
                $sar = $sar + (($sb * 12 * 22 * $pd) / (360 * 100));
            } else {
                $sar = $sar + (($sb * 12 * 18 * $pd) / (360 * 100));
            }
        }

        return $sar;
    }

}