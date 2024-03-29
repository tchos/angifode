body {
background: linear-gradient(
rgba(255, 255, 255, 0.9),
rgba(255, 255, 255, 0.9)
), url("{{ asset('asset/images/angifode.png') }}") white no-repeat center center;
}

<style>
    #div2 {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%,-50%);
        filter:alpha(opacity=10);
        -moz-opacity:0.1;
        opacity: 0.1;
    }
    #main{
        position: relative;
        height: 100vh;
    }
</style>
<main id="div2">
    <img src="{{ asset('asset/images/angifode.png') }}" width="800px" alt="">
</main>


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
<script type="text/javascript">
        $(document).ready(function(){
            $("#detachement_matricule").autocomplete({
                source: '{{ asset('asset/php/search-matricule.php') }}',
                minLength: 3,
            });
        });
    </script>
    <script>
        $(document).ready(function(){
            $("#detachement_matricule").blur(function(){
                $("#detachement_noms").val(noms);
                $("#detachement_dateNaissance").val(date_naissance);
                $("#detachement_dateIntegration").val(date_integration);
            });
        });
    </script>
                $derniereDate = $prochaineAvct;
                $prochaineAvct = $prochaineAvct + "2 ans";
            }

            // dernière période<script type="text/javascript">
        $(document).ready(function(){
            $("#detachement_matricule").autocomplete({
                source: '{{ asset('asset/php/search-matricule.php') }}',
                minLength: 3,
            });
        });
    </script>
    <script>
        $(document).ready(function(){
            $("#detachement_matricule").blur(function(){
                $("#detachement_noms").val(noms);
                $("#detachement_dateNaissance").val(date_naissance);
                $("#detachement_dateIntegration").val(date_integration);
            });
        });
    </script>
            $pd = $dateFin - $derniereDate - 1;
            if($typeAgent == 1 )
                $sommeAReverser = $sommeAReverser + ( ($salaire * 12 * 22 * $pd) / (360 * 100) );
            else
                $sommeAReverser = $sommeARe<script type="text/javascript">
        $(document).ready(function(){
            $("#detachement_matricule").autocomplete({
                source: '{{ asset('asset/php/search-matricule.php') }}',
                minLength: 3,
            });
        });
    </script>
    <script>
        $(document).ready(function(){
            $("#detachement_matricule").blur(function(){
                $("#detachement_noms").val(noms);
                $("#detachement_dateNaissance").val(date_naissance);
                $("#detachement_dateIntegration").val(date_integration);
            });
        });
    </script>verser + ( ($salaire * 12 * 18 * $pd) / (360 * 100) );

            return $sommeAReverser;

        }else { // Il y aura plusieurs barèmes en jeu
            $i = 0;<script type="text/javascript">
        $(document).ready(function(){
            $("#detachement_matricule").autocomplete({
                source: '{{ asset('asset/php/search-matricule.php') }}',
                minLength: 3,
            });
        });
    </script>
    <script>
        $(document).ready(function(){
            $("#detachement_matricule").blur(function(){
                $("#detachement_noms").val(noms);
                $("#detachement_dateNaissance").val(date_naissance);
                $("#detachement_dateIntegration").val(date_integration);
            });
        });
    </script>

            // on capte le premier barème
            while ($dateDebut > $bareme[$i]) {
                $i++;
                if($bareme[$i] >= $dateDebu<script type="text/javascript">
        $(document).ready(function(){
            $("#detachement_matricule").autocomplete({
                source: '{{ asset('asset/php/search-matricule.php') }}',
                minLength: 3,
            });
        });
    </script>
    <script>
        $(document).ready(function(){
            $("#detachement_matricule").blur(function(){
                $("#detachement_noms").val(noms);
                $("#detachement_dateNaissance").val(date_naissance);
                $("#detachement_dateIntegration").val(date_integration);
            });
        });
    </script>t)
                    $prochainBareme = $bareme;
            }

            //if($prochaineAvct < $prochainBareme)
        }<script type="text/javascript">
        $(document).ready(function(){
            $("#detachement_matricule").autocomplete({
                source: '{{ asset('asset/php/search-matricule.php') }}',
                minLength: 3,
            });
        });
    </script>
    <script>
        $(document).ready(function(){
            $("#detachement_matricule").blur(function(){
                $("#detachement_noms").val(noms);
                $("#detachement_dateNaissance").val(date_naissance);
                $("#detachement_dateIntegration").val(date_integration);
            });
        });
    </script>
        
/**
     * Retourne les sommes à reverser pour un agent détaché
     * @Return array
     */<script type="text/javascript">
        $(document).ready(function(){
            $("#detachement_matricule").autocomplete({
                source: '{{ asset('asset/php/search-matricule.php') }}',
                minLength: 3,
            });
        });
    </script>
    <script>
        $(document).ready(function(){
            $("#detachement_matricule").blur(function(){
                $("#detachement_noms").val(noms);
                $("#detachement_dateNaissance").val(date_naissance);
                $("#detachement_dateIntegration").val(date_integration);
            });
        });
    </script>
    public function getPeriodes($dateDebut, $dateFin){

        // Dates barème
        $bareme = $this->dateSalaire($dateDebut, $dateFin);
<script type="text/javascript">
        $(document).ready(function(){
            $("#detachement_matricule").autocomplete({
                source: '{{ asset('asset/php/search-matricule.php') }}',
                minLength: 3,
            });
        });
    </script>
    <script>
        $(document).ready(function(){
            $("#detachement_matricule").blur(function(){
                $("#detachement_noms").val(noms);
                $("#detachement_dateNaissance").val(date_naissance);
                $("#detachement_dateIntegration").val(date_integration);
            });
        });
    </script>
        // Va contenir toutes les périodes de détachement
        $tableauPeriode = [];

        // Date de début
        //$tableauPeriode[] = date_format($dateDebut, 'Y-m-d');
        //$tableauPeriode[] = date_format($dateFin, 'Y-m-d');
        $tableauPeriode[] = $dateDebut;
        $tableauPeriode[] = $dateFin;<script type="text/javascript">
        $(document).ready(function(){
            $("#detachement_matricule").autocomplete({
                source: '{{ asset('asset/php/search-matricule.php') }}',
                minLength: 3,
            });
        });
    </script>
    <script>
        $(document).ready(function(){
            $("#detachement_matricule").blur(function(){
                $("#detachement_noms").val(noms);
                $("#detachement_dateNaissance").val(date_naissance);
                $("#detachement_dateIntegration").val(date_integration);
            });
        });
    </script>
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
    
    SELECT MIN(INDICE) AS ind_sol FROM `bareme` WHERE grade="42210" AND  `INDICE` > 335;
    
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
  
  <li class="nav-item dropdown me-4">
    <a class="nav-link active dropdown-toggle fs-6" data-bs-toggle="dropdown" href="#" role="button"
       aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-bar-chart" aria-hidden="true"></i>
        Statistiques</a>
    <div class="dropdown-menu">
        <a class="dropdown-item" href="#">Action</a>
        <a class="dropdown-item" href="#">Another action</a>
        <a class="dropdown-item" href="#">Something else here</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="#">Separated link</a>
    </div>
</li>

/**
     * Retourne le salaire de base sur une période
     * @return Integer
     */
    public function getSalaire($dateDebut, $dateFin, $grade, $indice, $echelon) {

        //select salaire_base from bareme where grade="42210" AND classe="2" AND echelon="01"
        // AND num_bar IN (select num_bar from type_bareme where date_debut <= "2003-09-01" and date_fin >= "2002-02-11");
        //Liste des agants pour lesquels on n'a pas encore cotisé
        return $this->manager->createQuery(
            "SELECT MAX(b.salaireBase)
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
  
  <div class="row-cols-2 justify-content-center d-flex align-items-center">

                {{ form_row(registrationForm.organisme) }}
                {{ form_row(registrationForm.roles) }}
                {{ form_row(registrationForm.activation) }}

                <button type="submit" class="btn btn-success">
                    <i class="fa fa-check-circle" aria-hidden="true"></i>
                    Créer le compte
                </button>

            </div>
  
  function diff360($date1, $date2) {
    $date1 = new DateTime($date1);
    $date2 = new DateTime($date2);
    $diff = $date1->diff($date2);
    $days = ($date2->format('d') + 30 - $date1->format('d')) % 30;
    return array(
        "y" => $diff->y,
        "m" => $diff->m,
        "d" => $days,
        "totaldays" => $diff->y * 360 + $diff->m * 30 + $days
    );
}

$periodes = $services->getPeriodes($dateDebut, $dateFin);
dd($periodes);
 grade CT: 61150 61180 61200
select salaire_base from bareme where grade="61200" AND echelon = "02" AND num_bar IN (select num_bar from type_bareme where date_debut <= "2003-09-01" and date_fin >= "2002-02-11");
select DISTINCT(grade) from bareme where corps = "60" OR corps ="61";
SELECT MIN(ECHELON) AS echelon_solde FROM `bareme` WHERE grade="61200" AND  `ECHELON` > "11";
SELECT YEAR(date_det) as annee_detachement, COUNT(matricule) AS nbreDetaches FROM agent_detache GROUP BY annee_detachement ORDER BY annee_detachement;

{{ organisme.telephone1 }}{% if organisme.telephone2 %} / {{ organisme.telephone2 }}{% endif %}
{#
{{ asset("asset/preuves/") }}{{ organisme }}/{{ year }}/{{ reversement.preuveRev }}
    href="{{ asset("asset/preuves/" ~ organisme ~ "/" ~ year ~ "/" ~ "/" ~ reversement.preuveRev ) }}"
#}

<script>
        $(document).ready(function(){
            var azemDataTable = $('#agentsdetaches').DataTable({
                dom: 'Blfrtip',
                buttons: [
                    {
                        extend: 'copy',
                        text:      '<i class="fas fa-copy" style="font-size:25px;color:blue;"></i>',
                    },
                    {
                        extend: 'pdf',
                        text:      '<i class="fas fa-file-pdf" style="font-size:25px;color:red;"></i>',
                        exportOptions: {
                            columns: [0,1,2] // Column index which needs to export
                        }
                    },
                    {
                        extend: 'csv',
                        text:      '<i class="fas fa-file-alt" style="font-size:25px;color:black;"></i>',
                    },
                    {
                        extend: 'excel',
                        text:      '<i class="fas fa-file-excel" style="font-size:25px;color:darkgreen;"></i>',
                    }
                ]
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function(){
            $("#detachement_matricule").autocomplete({
                source: '{{ asset('asset/php/search-matricule.php') }}',
                minLength: 3,
            });
        });
    </script>
    <script>
        $(document).ready(function(){
            $("#detachement_matricule").blur(function(){
                $("#detachement_noms").val(noms);
                $("#detachement_dateNaissance").val(date_naissance);
                $("#detachement_dateIntegration").val(date_integration);
            });
        });
    </script>
  
  

