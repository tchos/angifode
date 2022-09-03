SELECT agent_id FROM cotisation WHERE reversement_id = 5;
SELECT id, matricule, noms FROM agent_detache WHERE id NOT IN (SELECT agent_id FROM cotisation WHERE reversement_id = 5);

'SELECT a.id, a.noms, a.matricule
            FROM App\Entity\AgentDetache a
            WHERE a.id NOT IN ( SELECT c.agent 
                                FROM App\Entity\Cotisation c 
                                JOIN c.reversement r
                                WHERE r = :reversement)'
                             
'class' => AgentDetache::class

return $this->statistiques->getListeACotiser($reversement);
'class' => AgentDetache::class,

'label' => 'Agents détachés',
                'class' => AgentDetache::class,
                'query_builder' => function(Statistiques $stats) use ($reversement){
                    return $stats->getListeACotiser($reversement);
                },
                'choice_label' => 'nom'
                
KOLLO MITTERAND - (456456A) value="4"

return $this->manager->createQuery(
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
            
$this->addFlash(
            "success",
            "La cotisation de l'agent <strong>" . $agent->getNoms() . "(" . $agent->getMatricule() . ") 
                </strong> du reversement " . $reversement . ", a bien été supprimé");
