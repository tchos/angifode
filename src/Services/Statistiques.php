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
        foreach ($agentsNonCotiser as $i=>$val) {
            $anc[$agentsNonCotiser[$i]['nom']] = $agentsNonCotiser[$i]['id'];
        }
        return $anc;
    }
}