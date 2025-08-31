<?php

namespace App\Services;

use App\Repository\BaremeRepository;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Node\Scalar\String_;

class BI
{
    private $manager;

    public function __construct(EntityManagerInterface $manager, BaremeRepository $reposBareme)
    {
        $this->manager = $manager;
    }

    /**
     * SAR par année et par organisme
     * @return array
     */
    public function getSarByYear(){
        /**
         * SELECT YEAR(date_rev) AS ANNEE_REVERSEMENT, sigle AS ORGANISME, SUM(montant_rev) AS TOTAL_REVSERSEMENT
         * FROM reversement, organismes
         * WHERE reversement.organisme_id = organismes.id GROUP BY ANNEE_REVERSEMENT,ORGANISME;
         */
        //Total des sommes reversées par année
        return $this->manager->createQuery (
            "   SELECT SUBSTRING(r.dateRev, 1, 4) as annee_reversement, SUM(r.montantRev) as total_reverse
                FROM App\Entity\Reversement r
                GROUP BY annee_reversement
                ORDER BY annee_reversement
            "
        )
            ->getResult();
    }
    /** Fin de la fonction getSarByYear() */

    /**
     * SAR par année et par organisme
     * @return array
     */
    public function getSarByYearByOrganisme(){
        /**
         * SELECT YEAR(date_rev) AS ANNEE_REVERSEMENT, sigle AS ORGANISME, SUM(montant_rev) AS TOTAL_REVSERSEMENT
         * FROM reversement, organismes
         * WHERE reversement.organisme_id = organismes.id GROUP BY ANNEE_REVERSEMENT,ORGANISME;
         */
        //Total des sommes reversées par année en mettant de côté le MINFI
        return $this->manager->createQuery (
            "   SELECT SUBSTRING(r.dateRev, 1, 4) as annee_reversement, o.sigle as organisme, SUM(r.montantRev) as total_reverse
                FROM App\Entity\Reversement r
                JOIN r.organisme o
                WHERE o.sigle != 'MINFI'
                GROUP BY annee_reversement, organisme
                ORDER BY annee_reversement
            "
        )
            ->getResult();
    }
    /** Fin de la fonction getSarByYearByOrganisme() */

    /**
     * SAR par organisme et par trimestre sur une année donnée
     * @return array
     */
    public function getSarByTrimByOrganisme($year){
        /**
         * SELECT (CASE WHEN MONTH(date_rev) < 4 THEN 'Trimestre I' WHEN MONTH(date_rev) > 3 && MONTH(date_rev) <= 6 THEN 'Trimestre II'
         * WHEN MONTH(date_rev) > 6 && MONTH(date_rev) <= 9 THEN 'Trimestre III' ELSE 'Trimestre IV' END) AS trimestre,
         * sigle AS ORGANISME, SUM(montant_rev) AS TOTAL_REVSERSEMENT FROM reversement, organismes
         * WHERE reversement.organisme_id = organismes.id AND YEAR(daTe_rev) = "2022" GROUP BY trimestre,ORGANISME ORDER BY trimestre;
         */
        //Total des sommes reversées par année
        return $this->manager->createQuery (
            "   SELECT (CASE WHEN SUBSTRING(r.dateRev,6,2) < 4 THEN 'Trimestre I' WHEN SUBSTRING(r.dateRev,6,2) > 3 
                    AND SUBSTRING(r.dateRev,6,2) <= 6 THEN 'Trimestre II' WHEN SUBSTRING(r.dateRev,6,2) > 6 AND SUBSTRING(r.dateRev,6,2) <= 9 THEN 'Trimestre III' 
                    ELSE 'Trimestre IV' END) AS trimestre, o.sigle as organisme, SUM(r.montantRev) as total_reverse
                FROM App\Entity\Reversement r
                JOIN r.organisme o
                WHERE o.sigle != 'MINFI' AND SUBSTRING(r.dateRev, 1, 4) = :year
                GROUP BY trimestre, organisme
                ORDER BY trimestre
            "
        )   ->setParameter('year', $year)
            ->getResult();
    }
    /** Fin de la fonction getSarByTrimByOrganisme() */

    /**
     * Liste des organismes qui n'ont effectué aucun reversement dans l'année en cours
     * @return array
     */
    public function getAnyPayInYear() {
        /**
         * SELECT sigle, libelle_org, telephone1, telephone2, email FROM organismes WHERE organismes.id
         * NOT IN (SELECT DISTINCT(organisme_id) FROM reversement WHERE YEAR(date_rev) = YEAR(CURDATE()));
         */
        return $this->manager->createQuery(
            "   SELECT o.sigle, o.libelleOrg, o.telephone1, o.telephone2, o.email 
                FROM App\Entity\Organismes o 
                WHERE o.sigle != 'MINFI' AND o.id NOT IN (
                    SELECT DISTINCT(r.organisme) 
                    FROM App\Entity\Reversement r 
                    WHERE SUBSTRING(r.dateRev, 1, 4) = SUBSTRING(CURRENT_DATE(), 1, 4)
                )"
        )->getResult();
    }
    /** Fin de la fonction getAnyReversementInYear() */

    /**
     * Liste des organismes qui n'ont jamais reversé les cotisation des droits à pension
     * @return array
     */
    public function getNeverPay() {
        return $this->manager->createQuery(
            "   SELECT o.sigle, o.libelleOrg, o.telephone1, o.telephone2, o.email 
                FROM App\Entity\Organismes o 
                WHERE o.sigle != 'MINFI' AND o.id NOT IN (
                    SELECT DISTINCT(r.organisme) 
                    FROM App\Entity\Reversement r 
                )"
        )->getResult();
    }
    /** Fin de la fonction getNeverPay() */

    /**
     * Affiche le nbre de détachés par structure
     * @return array
     */
    public function getNbreDetacheByOrganisme(){
        /**
         * SELECT organismes.id AS id, organismes.sigle AS organisme, COUNT(matricule) AS nbreDetaches
         * FROM agent_detache, organismes
         * WHERE agent_detache.organisme_id = organismes.id GROUP BY id, organisme ORDER BY nbreDetaches DESC;
         */
        return $this->manager->createQuery(
            "   SELECT o.id AS id, o.sigle AS sigle, o.libelleOrg AS libelleOrganisme, COUNT(a.matricule) AS nbreDetaches
                FROM App\Entity\AgentDetache a
                JOIN a.organisme o
                GROUP BY id, sigle
                ORDER BY nbreDetaches DESC
            "
        )->getResult();
    }

    /**
     * Donne l'effectif des nouveaux détachés par an
     * @return array
     */
    public function getNewDetacheByYear(){
        /**
         * SELECT YEAR(date_det) as annee_detachement, COUNT(matricule) AS nbreDetaches
         * FROM agent_detache GROUP BY annee_detachement ORDER BY annee_detachement;
         */
        return $this->manager->createQuery(
            "   SELECT SUBSTRING(a.dateDet, 1, 4) AS annee_detachement, COUNT(a.matricule) AS nbreDetaches
                FROM App\Entity\AgentDetache a GROUP BY annee_detachement ORDER BY annee_detachement
            "
        )->getResult();
    }

    /**
     * Permet de voir les nouveaux détachés sur une année donnée
     * @param $anDet
     * @return array
     */
    public function getDetachesByYear($anDet){
        /**
         * SELECT date_det as date_detachement, matricule, noms, ministere, ref_acte_det, telephone, sigle, libelle_org
         * FROM agent_detache, organismes WHERE agent_detache.organisme_id = organismes.id AND YEAR(date_det) = "2015";
         */
        return $this->manager->createQuery(
            "   SELECT a.matricule, a.noms, a.ministere, a.telephone, a.dateDet, a.refActeDet, o.sigle, o.libelleOrg
                FROM App\Entity\AgentDetache a JOIN a.organisme o
                WHERE SUBSTRING(a.dateDet, 1, 4) = :anDet"
        )   ->setParameter('anDet', $anDet)
            ->getResult();
    }
    /** Fin de la fonction getDetachesByYear($anDet) */

    /**
     * Permet de rechercher un agent à partir de son nom ou de son matricule
     * @param $infos
     * @return Entity Agents
     */
    public function searchAgentByNameOrMatricule($infos){
        /**
         * SELECT matricule, noms, dateNaissance as date_naissance, ministere, grade as code_grade, ministere, classe, echelon, libGrade as libelle_grade
         * FROM agents, grade WHERE agents.code_grade = grade.codeGrade AND (noms = "AGONI" OR matricule = "010013A");
         */
        $mots_cles = explode(' ', $infos);
        for ($i = 0; $i < sizeof($mots_cles); ++$i) {
            if ($i == 0) {
                $recherche = '
                    SELECT a.matricule, a.noms, a.dateNaissance as date_naissance, a.grade as code_grade, a.classe, a.echelon, 
                    g.libGrade as libelle_grade, a.ministere
                    FROM App\Entity\Agents a, App\Entity\Grade g
                    WHERE (a.matricule LIKE :mot_clef'.$i.' OR a.noms LIKE :mot_clef'.$i.')
                ';
            } else {
                $recherche .= ' AND (a.matricule LIKE :mot_clef'.$i.'
                    OR a.noms LIKE :mot_clef'.$i.')';
            }
        }

        $recherche .= ' AND a.grade = g.codeGrade';

        $query = $this->manager->createQuery($recherche);
        for ($i = 0; $i < sizeof($mots_cles); ++$i) {
            $mot_clef = trim($mots_cles[$i]);
            $query->setParameter('mot_clef'.$i.'', '%'.$mot_clef.'%');
        }

        return $query->getResult();
    }
    /** Fin de la fonction searchAgentByNameOrMatricule($nom) */
}