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
     * Cette fonction retourne la somme totale des reversements effectués par un organisme sur une période définie
     * @param $organisme
     * @param $periodeDebut
     * @param $periodeFin
     * @return float|int|mixed|string
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getTotalReversements($organisme, $periodeDebut, $periodeFin)
    {
        /**
         * select organisme_id, sigle, sum(montant_rev) as total_reverse
         * from reversement, organismes
         * where date_deb_rev >= "2022-01-01" and date_fin_rev <= "2022-12-31" and reversement.organisme_id = organismes.id and organisme_id=2
         * group by organisme_id,sigle;
         */
        return $this->manager->createQuery(
            "SELECT SUM(r.montantRev) AS totalReversements FROM App\Entity\Reversement r
             WHERE (r.dateDebRev >= :periodeDebut AND r.dateFinRev <= :periodeFin AND r.organisme = :organisme)"
        )
            ->setParameter('periodeDebut', $periodeDebut)
            ->setParameter('periodeFin', $periodeFin)
            ->setParameter('organisme', $organisme)
            ->getSingleScalarResult()
        ;
    }
    /** Fin fonction getTotalReversements() */

    /**
     * Cette fonction permet de calculer le totat des cotisations reversés pour un agent sur une période définie
     * @param $agent
     * @param $periodeDebut
     * @param $periodeFin
     * @return \Doctrine\ORM\Query
     */
    public function getTotalCotisations($agent, $periodeDebut, $periodeFin)
    {
        /**
         * select agent_id, sum(cot_totale) as total_cotise
         * from cotisation where date_debut_cot >= "2022-01-01" and date_fin_cot <= "2022-12-31" and agent_id = 9
         * group by agent_id;
         */
        return $this->manager->createQuery(
            "SELECT SUM(c.cotTotale) as total_cotisations FROM App\Entity\Cotisation c 
             WHERE c.dateDebutCot >= :periodeDebut AND c.dateFinCot <= :periodeFin AND c.agent = :agent"
        )
            ->setParameter('periodeDebut',$periodeDebut)
            ->setParameter('periodeFin',$periodeFin)
            ->setParameter('agent',$agent)
            ->getSingleScalarResult()
        ;
    }
    /** Fin fonction getTotalCotisations() */

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
    public function getListeACotiser($reversement, $organisme)
    {
        //Liste des agants pour lesquels on n'a pas encore cotisé
        $agentsNonCotiser = $this->manager->createQuery(
            "SELECT a.id, CONCAT(a.noms,' - (', a.matricule,')') as nom
                FROM App\Entity\AgentDetache a
                JOIN a.organisme o
                WHERE ( o = :organisme AND a.id NOT IN ( SELECT ad.id
                                FROM App\Entity\Cotisation c
                                JOIN c.agent ad
                                JOIN c.reversement r
                                WHERE r = :reversement ) )
                ORDER BY nom"
        )
            ->setParameter('organisme', $organisme)
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
    public function getSalaireFC($dateDebut, $dateFin, $grade, $indice) {

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
    /** Fin de la function getSalaireFC() pour les fonctionnaires  */

    /**
     * Cette fonction retourne le salire de base d'un agent du code du travail
     * @param $dateDebut
     * @param $dateFin
     * @param $grade
     * @param $echelon
     * @return float|int|mixed|string
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getSalaireCT($dateDebut, $dateFin, $grade, $echelon)
    {   //select salaire_base from bareme where grade="61200" AND echelon = "02"
        // AND num_bar IN (select num_bar from type_bareme where date_debut <= "2003-09-01" and date_fin >= "2002-02-11");
        return $this->manager->createQuery(
            "SELECT MAX(b.salaireBase)
                FROM App\Entity\Bareme b
                WHERE b.grade = :grade AND b.echelon = :echelon AND b.numBar IN ( 
                    SELECT t.numBar
                    FROM App\Entity\TypeBareme t
                    WHERE t.dateDebut <= :dateFin AND t.dateFin >= :dateDebut )
            "
        )
            ->setParameter('dateDebut', $dateDebut)
            ->setParameter('dateFin', $dateFin)
            ->setParameter('grade', $grade)
            ->setParameter('echelon', $echelon)
            ->getSingleScalarResult();
    }
    /** Fin de la function getSalaireCT() pour les agents du code du travail  */

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
        //SELECT MIN(INDICE) AS indice_solde FROM `bareme` WHERE grade="42210" AND  `INDICE` > 485;
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
     * Cette fonction retourne la date du dernier avancement
     * @param $dateIntegration
     * @param $dateDet
     * @return \DateTime|false
     */
    public function getDateDernierAvct($dateIntegration, $dateDet){
        $dateTampon = date_format($dateIntegration, 'Y-m-d');
        $dateDernAvct = date_create($dateTampon);
        if ($dateDernAvct < $dateDet) {
            while ($dateDernAvct < $dateDet) {
                date_add($dateDernAvct,date_interval_create_from_date_string("2 years"));
            }
            date_sub($dateDernAvct,date_interval_create_from_date_string("2 years"));
        }
        return $dateDernAvct;
    }
    /** Fin de la function getDateDernierAvct() */

    /**
     * Cette fonction retourne l'indice exacte à la date de début àp partir de laquelle on veut évaluer la dette
     * @param $grade
     * @param $indicce
     * @return mixed
     */
    public function getFirstIndice($grade_det, $indice_det, $dateIntegration, $dateDebut, $dateDet)
    {
        $tableau_indice = [];
        $tableau_indice[] = $indice_det;
        $dateTampon = date_format($dateIntegration, 'Y-m-d');

        //Changement d'indice si avancement sinon l'indice reste inchangé
        //$dateAvct = date_create($dateTampon);
        $dateAvct = $this->getDateDernierAvct($dateIntegration,$dateDet);

        // Pour gérer les avancements, donc les changements d'indices
        while ($dateAvct < $dateDebut){
            date_add($dateAvct,date_interval_create_from_date_string("2 years"));
            if ($this->getNextIndice($grade_det, $indice_det) != NULL ) {
                $indice_det = $this->getNextIndice($grade_det, $indice_det);
                $tableau_indice[] = $indice_det;
            }
        }

        //dd(array_key_last($tableau_indice) -1, $tableau_indice);
        if (count($tableau_indice) > 1) return $tableau_indice[array_key_last($tableau_indice) -1 ];
        else return $tableau_indice[array_key_last($tableau_indice) ];
    }
    /** Fin de la fonction getFirstIndice() */

    /**
     * Cette fonction renvoie le prochain echelon suivant un avct d'un agent du code du travail
     * @param $grade
     * @param $echelon
     * @return float|int|mixed|string
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getNextEchelon($grade, $echelon) {
        //SELECT MIN(ECHELON) AS echelon_solde FROM `bareme` WHERE grade="61200" AND  `ECHELON` > "11";
        return $this->manager->createQuery(
            "SELECT MIN(b.echelon) 
                FROM App\Entity\Bareme b
                WHERE b.grade = :grade AND b.echelon > :echelon
            "
        )
            ->setParameter('grade', $grade)
            ->setParameter('echelon', $echelon)
            ->getSingleScalarResult();
    }
    /** Fin de la fonction getNextEchelon() */

    /**
     * Cette fonction retourne l'indice exacte à la date de début àp partir de laquelle on veut évaluer la dette
     * @param $grade_det
     * @param $echelon_det
     * @param $dateIntegration
     * @param $dateDebut
     * @return $echelon_det
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getFirstEchelon($grade_det, $echelon_det, $dateIntegration, $dateDebut, $dateDet)
    {
        $tableau_echelon = [];
        $tableau_echelon[] = $echelon_det;
        $dateTampon = date_format($dateIntegration, 'Y-m-d');

        //Changement d'echelon si avancement sinon l'echelon reste inchangé
        //$dateAvct = date_create($dateTampon);
        $dateAvct = $this->getDateDernierAvct($dateIntegration,$dateDet);

        // Pour gérer les avancements, donc les changements d'echelon
        while ($dateAvct < $dateDebut){
            date_add($dateAvct,date_interval_create_from_date_string("2 years"));
            if ($this->getNextEchelon($grade_det, $echelon_det) != NULL ) {
                $echelon_det = $this->getNextEchelon($grade_det, $echelon_det);
                $tableau_echelon[] = $echelon_det;
            }
        }
        if(count($tableau_echelon) > 1 ) return $tableau_echelon[array_key_last($tableau_echelon) -1 ];
        else $tableau_echelon[array_key_last($tableau_echelon) ];
    }
    /** Fin de la fonction getFirstEchelon() */

    /**
     * Retourne la somme à reverser sur une période de date pour les fonctionnaires
     * @Return Integer
     */
    public function getSommeAReverserFC($dateDebut, $dateFin, $indice, $gradeDet, $dateIntegration)
    {
        $sar = 0;
        $detailsEsdAgent = [];
        $dataEsd = [];
        $dateTampon = date_format($dateIntegration, 'Y-m-d');

        $tableauPeriode = $this->getPeriodes($dateDebut, $dateFin, $dateIntegration);

        $dateD = date_create($tableauPeriode[0]);
        $dateF = date_create($tableauPeriode[1]);

        // La dernière date dans le tableau des périodes doit être la date de fin
        if($dateFin != $dateF){
            date_sub($dateF,date_interval_create_from_date_string("1 day"));
        }

        //Données détaillant le calcul de l'ESD d'un agent sur une période .
        $detailsEsdAgent["dateDebut"] = $dateD;
        $detailsEsdAgent["dateFin"] = $dateF;
        $detailsEsdAgent["indice"] = $indice;

        $sb = $this->getSalaireFC($dateD, $dateF, $gradeDet, $indice);
        $detailsEsdAgent["sb"] = $sb;

        //$pd = 1 + $dateD->diff($dateF)->days;
        $pd = 1 + $this->diff360($dateD, $dateF);
        $sarPD = (($sb * 12 * 22 * $pd) / (360 * 100));
        //dd($sarPD, $sb, $dateD, $dateF, $pd, $this->diff360($dateD, $dateF));
        $sar += $sarPD;

        //Données détaillant le calcul de l'ESD d'un agent sur une période .
        $detailsEsdAgent["partSalariale"] = ($sar * 10)/22;
        $detailsEsdAgent["partPatronale"] = ($sar * 12)/22;
        $detailsEsdAgent["sar"] = $sarPD;

        //Première ligne de détails sur le calcul des ESD de l'agent
        $dataEsd[] = $detailsEsdAgent;

        //Changement d'indice si avancement sinon l'indice reste inchangé
        $dateAvct = date_create($dateTampon);
        /**
        // Pour gérer les avancements, donc les changements d'indices
        while ($dateAvct < $dateDebut)
            date_add($dateAvct,date_interval_create_from_date_string("2 years"));
         * */

        $dateAvct = $this->getDateDernierAvct(date_create($dateTampon), $dateDebut);

        for ($i = 1; $i < count($tableauPeriode)-1; $i++)
        {
            $dateD = date_create($tableauPeriode[$i]);
            $dateF = date_create($tableauPeriode[$i+1]);
            // La dernière date dans le tableau des périodes doit être la date de fin
            //dd($dateFin, $tableauPeriode);
            if($dateFin != $dateF){
                date_sub($dateF,date_interval_create_from_date_string("1 day"));
            }

            //Données détaillant le calcul de l'ESD d'un agent sur une période .
            $detailsEsdAgent["dateDebut"] = $dateD;
            $detailsEsdAgent["dateFin"] = $dateF;

            date_add($dateAvct,date_interval_create_from_date_string("2 years"));

            if ($dateD == $dateAvct){
                if ($this->getNextIndice($gradeDet, $indice) != NULL ) {
                    $indice = $this->getNextIndice($gradeDet, $indice);
                }
            } else {
                date_sub($dateAvct,date_interval_create_from_date_string("2 years"));
            }
            //dd($dateD, $dateAvct, $indice);
            $sb = $this->getSalaireFC($dateD, $dateF, $gradeDet, $indice);

            //Données détaillant le calcul de l'ESD d'un agent sur une période .
            $detailsEsdAgent["indice"] = $indice;
            $detailsEsdAgent["sb"] = $sb;

            //$pd = 1 + $dateD->diff($dateF)->days;
            $pd = 1 + $this->diff360($dateD, $dateF);
            //Somme à reverser sur la période
            $sarPD = (($sb * 12 * 22 * $pd) / (360 * 100));
            $sar += $sarPD;

            //Données détaillant le calcul de l'ESD d'un agent sur une période .
            $detailsEsdAgent["partSalariale"] = ($sarPD * 10)/22;
            $detailsEsdAgent["partPatronale"] = ($sarPD * 12)/22;
            $detailsEsdAgent["sar"] = $sarPD;

            //Ligne i de détails sur le calcul des ESD de l'agent
            $dataEsd[] = $detailsEsdAgent;
        }

        return $dataEsd;
    }
    /** Fin de la function getSommeAReverserFC() pour les fonctionnaire */

    /**
     * Retourne la somme à reverser sur une période de date pour les agents du code du travail
     * @Return Integer
     */
    public function getSommeAReverserCT($dateDebut, $dateFin, $echelon, $gradeDet, $dateIntegration)
    {
        $sar = 0;
        $detailsEsdAgent = [];
        $dataEsd = [];
        $dateTampon = date_format($dateIntegration, 'Y-m-d');

        $tableauPeriode = $this->getPeriodes($dateDebut, $dateFin, $dateIntegration);

        $dateD = date_create($tableauPeriode[0]);
        $dateF = date_create($tableauPeriode[1]);

        // La dernière date dans le tableau des périodes doit être la date de fin
        if($dateFin != $dateF){
            date_sub($dateF,date_interval_create_from_date_string("1 day"));
        }

        //Données détaillant le calcul de l'ESD d'un agent sur une période .
        $detailsEsdAgent["dateDebut"] = $dateD;
        $detailsEsdAgent["dateFin"] = $dateF;
        $detailsEsdAgent["echelon"] = $echelon;

        $sb = $this->getSalaireCT($dateD, $dateF, $gradeDet, $echelon);
        $detailsEsdAgent["sb"] = $sb;
        //Période de détachement
        $pd = 1 + $this->diff360($dateD, $dateF);
        //Somme à réverser sur la période
        $sarPD = (($sb * 12 * 18 * $pd) / (360 * 100));
        $sar += $sarPD;

        //Données détaillant le calcul de l'ESD d'un agent sur une période .
        $detailsEsdAgent["partSalariale"] = ($sar * 6)/18;
        $detailsEsdAgent["partPatronale"] = ($sar * 12)/18;
        $detailsEsdAgent["sar"] = $sarPD;

        //Première ligne de détails sur le calcul des ESD de l'agent
        $dataEsd[] = $detailsEsdAgent;

        //Changement d'indice si avancement sinon l'indice reste inchangé
        $dateAvct = date_create($dateTampon);
        // Pour gérer les avancements, donc les changements d'indices
        while ($dateAvct < $dateDebut)
            date_add($dateAvct,date_interval_create_from_date_string("2 years"));

        $dateAvct = $this->getDateDernierAvct(date_create($dateTampon), $dateDebut);
        for ($i = 1; $i < count($tableauPeriode)-1; $i++) {

            $dateD = date_create($tableauPeriode[$i]);
            $dateF = date_create($tableauPeriode[$i+1]);
            // La dernière date dans le tableau des périodes doit être la date de fin
            if($dateFin != $dateF){
                date_sub($dateF,date_interval_create_from_date_string("1 day"));
            }

            //Données détaillant le calcul de l'ESD d'un agent sur une période .
            $detailsEsdAgent["dateDebut"] = $dateD;
            $detailsEsdAgent["dateFin"] = $dateF;

            date_add($dateAvct,date_interval_create_from_date_string("2 years"));
            //A chaque avct, les echelon changent et donc le salaire de base augmente
            if ($dateD == $dateAvct){
                if ($this->getNextEchelon($gradeDet, $echelon) != NULL ) {
                    $echelon = $this->getNextEchelon($gradeDet, $echelon);
                }
            } else {
                date_sub($dateAvct,date_interval_create_from_date_string("2 years"));
            }

            $sb = $this->getSalaireCT($dateD, $dateF, $gradeDet, $echelon);

            //Données détaillant le calcul de l'ESD d'un agent sur une période .
            $detailsEsdAgent["echelon"] = $echelon;
            $detailsEsdAgent["sb"] = $sb;

            //$pd = 1 + $dateD->diff($dateF)->days;
            $pd = 1 + $this->diff360($dateD, $dateF);
            //Somme à reverser sur la période de détachement
            $sarPD = (($sb * 12 * 18 * $pd) / (360 * 100));
            $sar += $sarPD;

            //Données détaillant le calcul de l'ESD d'un agent sur une période .
            $detailsEsdAgent["partSalariale"] = ($sarPD * 6)/18;
            $detailsEsdAgent["partPatronale"] = ($sarPD * 12)/18;
            $detailsEsdAgent["sar"] = $sarPD;

            //Ligne i de détails sur le calcul des ESD de l'agent
            $dataEsd[] = $detailsEsdAgent;
        }

        return $dataEsd;
    }
    /** Fin de la function getSommeAReverser() pour les agents du code du travail */

    /**
     * Cette fonction calcule le nombre de jours entre 2 dates en prenant chaque mois comme un mois financier (30 jours)
     * @param $date1
     * @param $date2
     * @return Integer
     */
    function diff360($date1, $date2) {
        if ($date1->format('y') == $date2->format('y') && $date1->format('m') == $date2->format('m')){
            /** On retourne 29 pour l'évaluation de l'ESD mensuelle
             * à quoi on va ajouter 1 jour dans la fonction qui évalue la somme à reverser
             */
            //return 29;
        };
        // $date2 = date_create("2023-06-30"); $date1 = date_create("2023-06-01");
        $diff = $date1->diff($date2);
        $days = (($date2->format('d') + 30) - ($date1->format('d'))) % 30;

        return ($diff->y * 360) + ($diff->m * 30) + $days;
    }
}