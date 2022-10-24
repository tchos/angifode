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
     * Retourne la liste des organismes
     *
    public function getListeOrganismes($organisme)
    {
        //Liste des organismes
        $organismes = $this->manager->createQuery(
            "SELECT o.id, CONCAT(o.sigle,' - (', o.libelleOrg,')') as libelle
                FROM App\Entity\Organismes o
                WHERE o.sigle LIKE '%:organisme%'
                ORDER BY libelle"
        )
            ->setParameter('organisme', $organisme)
            ->getResult();

        $organismes = [];
        foreach ($org as $i => $val) {
            $organismes[$org[$i]['libelle']] = $org[$i]['id'];
        }
        return $organismes;
    }
*/

    /**
     * Renvoie l'indice au détachement.
     * @param $grade
     * @param $classe
     * @param $echelon
     * @return float|int|mixed|string
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getIndice($gradeDet, $classeDet, $echelonDet){
        // select MIN(indice) from bareme where grade = "42110" and classe = "1" and echelon = "01";
        return $this->manager->createQuery(
            'SELECT MIN(b.indice)
            FROM App\Entity\Bareme b
            WHERE b.grade = :grade AND b.classe = :classe AND b.echelon = :echelon'
        )
            ->setParameter('grade', $gradeDet)
            ->setParameter('classe', $classeDet)
            ->setParameter('echelon', $echelonDet)
            ->getSingleScalarResult()
        ;
    }
    /** Fin de la function getIndice() */

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
    /** Fin de la function getListeACotiser() */

    /**
     * Retourne le salaire de base sur une période donnée .
     * @return Bareme Returns an array of Bareme objects
     */
    public function dateSalaire($dateDebut, $dateFin) {
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
    /** Fin de la function dateSalaire() */

    /**
     * Retourne les sommes à reverser pour un agent détaché
     * @Return array
     */
    public function getPeriodes($dateDebut, $dateFin, $dateIntegration){

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
    /** Fin de la function getPeriodes() */

    /**
     * Retourne le salaire de base sur une période
     * @return Integer
     */
    public function getSalaire($dateDebut, $dateFin, $grade, $indice) {

        //select salaire_base from bareme where grade="42110" AND indice = 430
        // AND num_bar IN (select num_bar from type_bareme where date_debut <= "2003-09-01" and date_fin >= "2002-02-11");
        //Liste des agants pour lesquels on n'a pas encore cotisé
        return $this->manager->createQuery(
            "SELECT MAX(b.salaireBase)
                FROM App\Entity\Bareme b
                WHERE b.grade = :grade AND b.indice = :indice AND b.numBar IN ( 
                    SELECT t.numBar
                    FROM App\Entity\TypeBareme t
                    WHERE t.dateDebut <= :dateFin AND t.dateFin >= :dateDebut )
            "
        )
        ->setParameter('dateDebut', $dateDebut)
        ->setParameter('dateFin', $dateFin)
        ->setParameter('grade', $grade)
        ->setParameter('indice', $indice)
        ->getSingleScalarResult();
    }
    /** Fin de la function getSalaire() */

    /**
     * Cette fonction renvoie le prochain indice après un avancement dans un barème bien connu
     * pour les fonctionnaires détachés
     * @param $grade
     * @param $indice
     * @return float|int|mixed|string
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getNextIndice($grade, $indice) {
        //SELECT MIN(INDICE) AS ind_sol FROM `bareme` WHERE grade="42210" AND  `INDICE` > 485;
        return $this->manager->createQuery(
            "SELECT MIN(b.indice) 
                FROM App\Entity\Bareme b
                WHERE b.grade = :grade AND b.indice > :indice
            "
        )
            ->setParameter('grade', $grade)
            ->setParameter('indice', $indice)
            ->getSingleScalarResult();
    }
    /** Fin de la function getNextIndice() */

    /**
     * Cette fonction retourne l'indice exacte à la date de début àp partir de laquelle on veut
     * évaluer la dette.
     * @param $grade
     * @param $indicce
     * @return mixed
     */
    public function getFirstindice($grade_det, $indice_det, $dateIntegration, $dateDebut)
    {
        $tableau_indice = [];
        $tableau_indice[] = $indice_det;
        $dateTampon = date_format($dateIntegration, 'Y-m-d');

        //Changement d'indice si avancement sinon l'indice reste inchangé
        $dateAvct = date_create($dateTampon);
        // Pour gérer les avancements, donc les changements d'indices
        while ($dateAvct < $dateDebut){
            date_add($dateAvct,date_interval_create_from_date_string("2 years"));
            if ($this->getNextIndice($grade_det, $indice_det) != NULL ) {
                $indice_det = $this->getNextIndice($grade_det, $indice_det);
                $tableau_indice[] = $indice_det;
            }
        }
        return $tableau_indice[array_key_last($tableau_indice) -1 ];
    }
    /** Fin de la fonction getFirstIndice */

    public function getNextEchelon($grade, $indice) {

    }

    /**
     * Retourne la somme à reverser sur une période de date
     * @Return Integer
     */
    public function getSommeAReverser($dateDebut, $dateFin, $indice, $gradeDet, $dateIntegration) {
        $sar = 0;
        $detailsEsdAgent = [];
        $dataEsd = [];
        $dateTampon = date_format($dateIntegration, 'Y-m-d');

        // On récupère le type agent selon le grade.
        if ($gradeDet < "60000" || $gradeDet > "62000")
            $typeAgent = 1;
        else
            $typeAgent = 0;

        $tableauPeriode = $this->getPeriodes($dateDebut, $dateFin, $dateIntegration);

        $dateD = date_create($tableauPeriode[0]);
        $dateF = date_create($tableauPeriode[1]);

        date_sub($dateF,date_interval_create_from_date_string("1 day"));

        //Données détaillant le calcul de l'ESD d'un agent sur une période .
        $detailsEsdAgent["dateDebut"] = $dateD;
        $detailsEsdAgent["dateFin"] = $dateF;
        $detailsEsdAgent["indice"] = $indice;

        $sb = $this->getSalaire($dateD, $dateF, $gradeDet, $indice);
        $detailsEsdAgent["sb"] = $sb;

        //$pd = 1 + $dateD->diff($dateF)->days;
        $pd = 1 + $this->diff360($dateD, $dateF);

        if ($typeAgent == 1) {
            $sarPD = (($sb * 12 * 22 * $pd) / (360 * 100));
            $sar += $sarPD;
        } else {
            $sarPD = (($sb * 12 * 18 * $pd) / (360 * 100));
            $sar += $sarPD;
        }

        //Données détaillant le calcul de l'ESD d'un agent sur une période .
        $detailsEsdAgent["partSalariale"] = ($sar * 10)/22;
        $detailsEsdAgent["partPatronale"] = ($sar * 12)/22;
        $detailsEsdAgent["sar"] = $sarPD;

        //Première ligne de détails sur le calcul des ESD de l'agent
        $dataEsd[] = $detailsEsdAgent;

        //Changement d'indice si avancement sinon l'indice reste inchangé
        $dateAvct = date_create($dateTampon);
        // Pour gérer les avancements, donc les changements d'indices
        while ($dateAvct < $dateDebut)
            date_add($dateAvct,date_interval_create_from_date_string("2 years"));

        for ($i = 1; $i < count($tableauPeriode)-1; $i++) {

            $dateD = date_create($tableauPeriode[$i]);
            $dateF = date_create($tableauPeriode[$i+1]);
            date_sub($dateF,date_interval_create_from_date_string("1 day"));

            //Données détaillant le calcul de l'ESD d'un agent sur une période .
            $detailsEsdAgent["dateDebut"] = $dateD;
            $detailsEsdAgent["dateFin"] = $dateF;

            date_add($dateAvct,date_interval_create_from_date_string("2 years"));
            //dd($dateDebut, $dateD, $dateAvct);
            if ($dateD == $dateAvct){
                if ($this->getNextIndice($gradeDet, $indice) != NULL ) {
                    $indice = $this->getNextIndice($gradeDet, $indice);
                }
            } else {
                date_sub($dateAvct,date_interval_create_from_date_string("2 years"));
            }

            $sb = $this->getSalaire($dateD, $dateF, $gradeDet, $indice);

            //Données détaillant le calcul de l'ESD d'un agent sur une période .
            $detailsEsdAgent["indice"] = $indice;
            $detailsEsdAgent["sb"] = $sb;

            //$pd = 1 + $dateD->diff($dateF)->days;
            $pd = 1 + $this->diff360($dateD, $dateF);

            if ($typeAgent == 1) {
                $sarPD = (($sb * 12 * 22 * $pd) / (360 * 100));
                $sar += $sarPD;
            } else {
                $sarPD = (($sb * 12 * 18 * $pd) / (360 * 100));
                $sar += $sarPD;
            }

            //Données détaillant le calcul de l'ESD d'un agent sur une période .
            $detailsEsdAgent["partSalariale"] = ($sarPD * 10)/22;
            $detailsEsdAgent["partPatronale"] = ($sarPD * 12)/22;
            $detailsEsdAgent["sar"] = $sarPD;

            //Ligne i de détails sur le calcul des ESD de l'agent
            $dataEsd[] = $detailsEsdAgent;
        }

        return $dataEsd;
    }
    /** Fin de la function getSommeAReverser() */

    /**
     * Cette fonction calcule le nombre de jours entre 2 dates en prenant chaque mois comme un mois financier (30 jours)
     * @param $date1
     * @param $date2
     * @return Integer
     */
    function diff360($date1, $date2) {

        $diff = $date1->diff($date2);
        $days = ($date2->format('d') + 30 - $date1->format('d')) % 30;

        return $diff->y * 360 + $diff->m * 30 + $days;
    }
}