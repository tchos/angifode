<?php

namespace App\Services;

use App\Repository\BaremeRepository;
use Doctrine\ORM\EntityManagerInterface;

class BI
{
    private $manager;

    public function __construct(EntityManagerInterface $manager, BaremeRepository $reposBareme)
    {
        $this->manager = $manager;
    }

    /**
     * SAR par année et par organisme
     * @return float|int|mixed|string
     */
    public function getSarByYear(){
        /**
         * SELECT YEAR(date_rev) AS ANNEE_REVERSEMENT, sigle AS ORGANISME, SUM(montant_rev) AS TOTAL_REVSERSEMENT
         * FROM reversement, organismes
         * WHERE reversement.organisme_id = organismes.id GROUP BY ANNEE_REVERSEMENT,ORGANISME;
         */
        //Total des sommes reversées par année
        return $this->manager->createQuery (
            "SELECT SUBSTRING(r.dateRev, 1, 4) as annee_reversement, SUM(r.montantRev) as total_reverse
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
     * @return float|int|mixed|string
     */
    public function getSarByYearByOrganisme(){
        /**
         * SELECT YEAR(date_rev) AS ANNEE_REVERSEMENT, sigle AS ORGANISME, SUM(montant_rev) AS TOTAL_REVSERSEMENT
         * FROM reversement, organismes
         * WHERE reversement.organisme_id = organismes.id GROUP BY ANNEE_REVERSEMENT,ORGANISME;
         */
        //Total des sommes reversées par année
        return $this->manager->createQuery (
            "SELECT SUBSTRING(r.dateRev, 1, 4) as annee_reversement, o.sigle as organisme, SUM(r.montantRev) as total_reverse
                FROM App\Entity\Reversement r
                JOIN r.organisme o
                GROUP BY annee_reversement, organisme
                ORDER BY annee_reversement
            "
        )
            ->getResult();
    }
    /** Fin de la fonction getSarByYearByOrganisme() */

    /**
     * SAR par année et par organisme
     * @return float|int|mixed|string
     */
    public function getSarByTrimByOrganisme(){
        /**
         * SELECT YEAR(date_rev) AS ANNEE_REVERSEMENT, sigle AS ORGANISME, SUM(montant_rev) AS TOTAL_REVSERSEMENT
         * FROM reversement, organismes
         * WHERE reversement.organisme_id = organismes.id GROUP BY ANNEE_REVERSEMENT,ORGANISME;
         */
        //Total des sommes reversées par année
        return $this->manager->createQuery (
            "SELECT SUBSTRING(r.dateRev, 1, 4) as annee_reversement, o.sigle as organisme, SUM(r.montantRev) as total_reverse
                FROM App\Entity\Reversement r
                JOIN r.organisme o
                WHERE annee_reversement = :
                GROUP BY annee_reversement, organisme
                ORDER BY annee_reversement
            "
        )->getResult();
    }
    /** Fin de la fonction getSarByYearByOrganisme() */

    /**
     * Liste des organismes qui n'ont effectué aucun reversement dans l'année en cours
     * @return float|int|mixed|string
     */
    public function getAnyReversementInYear() {
        /**
         * SELECT sigle, libelle_org, telephone1, telephone2, email FROM organismes WHERE organismes.id
         * NOT IN (SELECT DISTINCT(organisme_id) FROM reversement WHERE YEAR(date_rev) = YEAR(CURDATE()));
         */
        return $this->manager->createQuery(
            "SELECT o.sigle, o.libelleOrg, o.telephone1, o.telephone2, o.email 
                FROM App\Entity\Organismes o 
                WHERE o.id NOT IN (
                    SELECT DISTINCT(r.organisme) 
                    FROM App\Entity\Reversement r 
                    WHERE SUBSTRING(r.dateRev, 1, 4) = SUBSTRING(CURRENT_DATE(), 1, 4)
                )"
        )->getResult();
    }
}