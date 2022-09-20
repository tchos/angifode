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
                
                
------ SERVICES.
$nbBareme = 0;
        $nbAvct = 0;
        // prochain avancement
        $prochaineAvct = "date prochain avancement";
        $derniereDate = $dateDebut;
        $sommeAReverser = 0;

        //On parcours d'abord les barèmes
        if($dateDebut >= "01-07-2014") { // Il n'y a qu'un seul barème en jeu

            while ($dateFin > $prochaineAvct) {
                $nbAvct++;
                $pd = $prochaineAvct - $derniereDate - 1;
                if($typeAgent == 1 )
                    $sommeAReverser = $sommeAReverser + ( ($salaire * 12 * 22 * $pd) / (360 * 100) );
                else
                    $sommeAReverser = $sommeAReverser + ( ($salaire * 12 * 18 * $pd) / (360 * 100) );

                $derniereDate = $prochaineAvct;
                $prochaineAvct = $prochaineAvct + "2 ans";
            }

            // dernière période
            $pd = $dateFin - $derniereDate - 1;
            if($typeAgent == 1 )
                $sommeAReverser = $sommeAReverser + ( ($salaire * 12 * 22 * $pd) / (360 * 100) );
            else
                $sommeAReverser = $sommeAReverser + ( ($salaire * 12 * 18 * $pd) / (360 * 100) );

            return $sommeAReverser;

        }else { // Il y aura plusieurs barèmes en jeu
            $i = 0;

            // on capte le premier barème
            while ($dateDebut > $bareme[$i]) {
                $i++;
                if($bareme[$i] >= $dateDebut)
                    $prochainBareme = $bareme;
            }

            //if($prochaineAvct < $prochainBareme)
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
        //$tableauPeriode[] = date_format($dateDebut, 'Y-m-d');
        //$tableauPeriode[] = date_format($dateFin, 'Y-m-d');
        $tableauPeriode[] = $dateDebut;
        $tableauPeriode[] = $dateFin;
        foreach ($bareme as $keys => $value) {
            foreach ($value as $key => $date) {
                if ($dateDebut <= $date && $date <= $dateFin)
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
    
    "2002-02-11"
  1 => "2003-11-01"
  2 => "2005-11-01"
  3 => "2007-11-01"
  4 => "2008-04-01"
  5 => "2009-11-01"
  6 => "2011-11-01"
  7 => "2013-11-01"
  8 => "2014-07-01"
  9 => "2015-11-01"
  10 => "2017-11-01"
  11 => "2019-11-01"
  12 => "2021-11-01"
  13 => "2022-09-10"
  
  <div class="row-cols-2 justify-content-center d-flex align-items-center">


                

                {{ form_row(registrationForm.organisme) }}
                {{ form_row(registrationForm.roles) }}
                {{ form_row(registrationForm.activation) }}

                <button type="submit" class="btn btn-success">
                    <i class="fa fa-check-circle" aria-hidden="true"></i>
                    Créer le compte
                </button>

            </div>
  
  
  

