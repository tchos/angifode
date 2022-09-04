<?php

namespace App\Services;

use App\Entity\AgentDetache;
use Doctrine\ORM\EntityManagerInterface;

class Statistiques
{
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
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
}