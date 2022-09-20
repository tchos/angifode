<?php

function date_fin_detachement($matricule,$categorie,$naiss){

$date_fin_det = dateFinDetachement($matricule);

$date_fin = 0;

if(!empty($date_fin_det)){ // recupéreration  du resultat
  $date_fin = $date_fin_det->dat_det_fin;
  }else{
  if(retraite($categorie,$naiss)){ 
    $date_fin = retraite($categorie,$naiss);
   }else{
    $date_fin = date("Y-m-d"); 
  }
}
return $date_fin;
}

function retraite($categorie,$naiss){
  if (($categorie=="A1") || ($categorie=="A2")){
      if (age($naiss)<60){
        return false; //pas encore à la retraite
       } else{
        list($annee,$mois,$jour)=explode("-",$naiss); 
        $annee_retraite=(int)$annee+60;$annee_retraite=$annee_retraite."-".$mois."-".$jour;
        return $annee_retraite;// déjà à la retriate
       }
    }
if (($categorie=="B1") || ($categorie=="B2")){
      if (age($naiss)<60){
        return false;//pas encore à la retraite
       } else {
        list($annee,$mois,$jour) = explode("-",$naiss); 
        $annee_retraite =(int)$annee+60; $annee_retraite=$annee_retraite."-".$mois."-".$jour;
        return $annee_retraite;// déjà à la retriate
       }
}
if (($categorie=="C") || ($categorie=="D")){
      if (age($naiss)<55){
        return false;//pas encore à la retraite
       } else {
        list($annee,$mois,$jour)=explode("-",$naiss); 
        $annee_retraite=(int)$annee+55; $annee_retraite=$annee_retraite."-".$mois."-".$jour;
        return $annee_retraite;// déjà à la retriate
       }
    }
 }

 function date_en($dat){
  $dateen="";
  list($j2,$m2,$a2)=explode("-",$dat);
  $dateen=$a2."-".$m2."-".$j2;
  return $dateen;
}
//--------- Date au format francais pour afficahge 
function date_fr($dat){
  $datefr ="";
  list($a2,$m2,$j2) = explode("-",$dat);
  $datefr = $j2."-".$m2."-".$a2;
  return $datefr;
}

function annee_quarante_ans($naiss){
  // Découper la date dans un tableau associatif
  list($annee,$mois,$jour)=explode("-",$naiss); 
  $annee=(int)$annee+40;
  $annee1=$annee."-".$mois."-".$jour;
  return $annee1;
}

function indice_suivant($ind,$cat){
  global $table_reversements;global $naiss;global $matricule;global $categorie;global $indice;global $num_bar;global $dbc;  global $annee_40_ans; global $echelon; global $grade; global $classe; global $echelon;
  $cat = $categorie; $ind =$indice; $grad = $grade; $class = $classe; $echl = $echelon; // echo'/'.age_avancement().'-'.$ind;
    if(($cat=="B1")&&(age_avancement()>40)){ 
      $cat="B2"; 
    }
    //if(($cat=="A1")&&(age_avancement()>40)){ $cat="A2"; }
    if(($cat=="A1")&&($ind>740)){ 
      if(age_avancement()>40){
        $cat="A2"; 
      } else{
        if($annee_40_ans!="0000-00-00"){
          echo "****".$annee_40_ans = annee_quarante_ans($naiss);
      }
    }
  }
  $categorie = $cat;
  $grade = $grad;
  $classe = $class;
  $echelon = $echl;
  $res = indiceSuivant($cat, $ind); 
  if (!empty($res)){
     $ind = $res->ind_sol;  
  }
  if($ind>$indice){ $indice=$ind;}
   return $indice;
}

function indice_suivant_magis($ind,$mat,$grad){
  global $table_reversements;global $naiss;global $matricule;global $categorie;global $indice;global $num_bar;global $dbc;  global $annee_40_ans; global $echelon; global $grade; global $classe; global $echelon;
  $cat = $categorie; $ind =$indice; $mat = $matricule; $grad = $grade;  // 

  $res = indiceSuivantMagis($ind,$mat,$grad);
  if (!empty($res)){
     $ind = $res->ind_sol;  
  }
  if($ind>$indice){ $indice=$ind;}
   return $indice;
}

 function echelon_suivant($cat,$echl){
  global $table_reversements;global $naiss;global $matricule;global $categorie; global $num_bar;global $dbc;  global $annee_40_ans; global $echelon; 
  $cat = $categorie; $echl = $echelon; // echo'/'.age_avancement().'-'.$ind;

   if(($cat=="01")&&($echl == 12)&&(age_avancement()>40)){ 
      $cat="02";
      $echl = "00"; 
    }
    if(($cat=="02")&&($echl == 12)&&(age_avancement()>40)){ 
      $cat="03";
      $echl = "00"; 
    }
    if(($cat=="03")&&($echl == 12)&&(age_avancement()>40)){ 
      $cat="04";
      $echl = "00"; 
    }
    if(($cat=="04")&&($echl == 12)&&(age_avancement()>40)){ 
      $cat="05";
      $echl = "00"; 
    }
    if(($cat=="05")&&($echl == 12)&&(age_avancement()>40)){ 
      $cat="06";
      $echl = "00"; 
    }
    if(($cat=="06")&&($echl == 12)&&(age_avancement()>40)){ 
      $cat="07";
      $echl = "00"; 
    }
    if(($cat=="07") && ($echl == 12)&&(age_avancement()>40)){ 
      $cat="08"; 
      $echl = "00";
    }
    if(($cat=="08") && ($echl == 12)&&(age_avancement()>40)){ 
      $cat="09"; 
      $echl = "00";
    }
    if(($cat=="09") && ($echl == 12)&&(age_avancement()>40)){ 
      $cat="10"; 
      $echl = "00";
    }
    if(($cat=="10") && ($echl == 12)&&(age_avancement()>40)){ 
      $cat="11"; 
      $echl = "00";
    }
    if(($cat=="11") && ($echl == 12)&&(age_avancement()>40)){ 
      $cat="12"; 
      $echl = "00";
    }
    //if(($cat=="A1")&&(age_avancement()>40)){ $cat="A2"; }
    if(($cat=="01")&&($echl>12)){ 
      if(age_avancement()>40){
        $cat="02"; 
        $echl = "00";
      } else{
        if($annee_40_ans!="0000-00-00"){
          echo "****".$annee_40_ans = annee_quarante_ans($naiss);
      }
    }
  }
  if(($cat=="02")&&($echl>12)){ 
      if(age_avancement()>40){
        $cat="03"; 
        $echl = "00";
      } else{
        if($annee_40_ans!="0000-00-00"){
          echo "****".$annee_40_ans = annee_quarante_ans($naiss);
      }
    }
  }
  if(($cat=="03")&&($echl>12)){ 
      if(age_avancement()>40){
        $cat="04"; 
        $echl = "00";
      } else{
        if($annee_40_ans!="0000-00-00"){
          echo "****".$annee_40_ans = annee_quarante_ans($naiss);
      }
    }
  }
  if(($cat=="04")&&($echl>12)){ 
      if(age_avancement()>40){
        $cat="05"; 
        $echl = "00";
      } else{
        if($annee_40_ans!="0000-00-00"){
          echo "****".$annee_40_ans = annee_quarante_ans($naiss);
      }
    }
  }
  if(($cat=="05")&&($echl>12)){ 
      if(age_avancement()>40){
        $cat="06"; 
        $echl = "00";
      } else{
        if($annee_40_ans!="0000-00-00"){
          echo "****".$annee_40_ans = annee_quarante_ans($naiss);
      }
    }
  }
  if(($cat=="06")&&($echl>12)){ 
      if(age_avancement()>40){
        $cat="07"; 
        $echl = "00";
      } else{
        if($annee_40_ans!="0000-00-00"){
          echo "****".$annee_40_ans = annee_quarante_ans($naiss);
      }
    }
  }
  if(($cat=="07")&&($echl>12)){ 
      if(age_avancement()>40){
        $cat="08"; 
        $echl = "00";
      } else{
        if($annee_40_ans!="0000-00-00"){
          echo "****".$annee_40_ans = annee_quarante_ans($naiss);
      }
    }
  }
  if(($cat=="08")&&($echl>12)){ 
      if(age_avancement()>40){
        $cat="09"; 
        $echl = "00";
      } else{
        if($annee_40_ans!="0000-00-00"){
          echo "****".$annee_40_ans = annee_quarante_ans($naiss);
      }
    }
  }
  if(($cat=="09")&&($echl>12)){ 
      if(age_avancement()>40){
        $cat="10"; 
        $echl = "00";
      } else{
        if($annee_40_ans!="0000-00-00"){
          echo "****".$annee_40_ans = annee_quarante_ans($naiss);
      }
    }
  }
  if(($cat=="10")&&($echl>12)){ 
      if(age_avancement()>40){
        $cat="11"; 
        $echl = "00";
      } else{
        if($annee_40_ans!="0000-00-00"){
          echo "****".$annee_40_ans = annee_quarante_ans($naiss);
      }
    }
  }
  if(($cat=="11")&&($echl>12)){ 
      if(age_avancement()>40){
        $cat="12"; 
        $echl = "00";
      } else{
        if($annee_40_ans!="0000-00-00"){
          echo "****".$annee_40_ans = annee_quarante_ans($naiss);
      }
    }
  }

  $categorie = $cat;
  $echelon = $echl;
  $res = echelonSuivant($echl, $cat); 
  if (!empty($res)){
     $echl = $res->echelon;  
  }
  if($echl>$echelon){ $echelon=$echl;}
   return $echl;
}

 function date_avancement($annee_integration,$annee_debut){
  $annee=$annee_integration;  
  while($annee<$annee_debut){
    $annee=dateupdate($annee);
  }
  
  return $annee;
}

 function age($naiss){
  // Découper la date dans un tableau associatif
  list($annee,$mois,$jour) = explode("-",$naiss); 
  // Récupérer la date actuelle dans des variables
  $today['mois'] = date('n');
  $today['jour'] = date('j');
  $today['annee'] = date('Y');
  // Calculer le nombre d'années entre l'année de naissance et l'année en cours
  $annees = $today['annee'] - $annee;
  // Si le mois en cours est inférieur au mois d'anniversaire, enlever un an
  if ($today['mois'] < $mois) {
    $annees--;
  }
  // Pareil si on est dans le bon mois mais que le jour n'est pas encore venu
  if ($mois == $today['mois'] && $jour > $today['jour']) {
    $annees--;
  }
  return $annees;
}

function dateupdate($date_up){
  list($a2,$m2,$j2)=explode("-",$date_up);
  $jour=$j2;
  $mois=$m2;
  $anne=(int)$a2;
  $anne=$anne+2;
  $ar=array($anne,$mois,$jour);
  $annedeux=implode("-",$ar);
  return $annedeux;
}
function Fdate($date_deb_f,$date_fin_f)
  {
//-------------------traitement date---------------------

    $anne_emp=0;$m_emp=0;
    list($a1,$m1,$j1)=explode("-",$date_deb_f);
    list($a2,$m2,$j2)=explode("-",$date_fin_f);
    $jourd=(int)$j1;
    $moisd=(int)$m1;
    $anned=(int)$a1;
    $jourf=(int)$j2;
    $moisf=(int)$m2;
    $annef=(int)$a2;
  //--------------------Appel de la fonction pour avoir le nbjour------------------------------------------------

      return 1 + Jour($jourd,$jourf) +Mois($moisd,$moisf)*30+ Anne($anned,$annef)*360;
  }
function etat_sommes_dues_periode_bareme($date_debut,$date_fin){
global $table_reversements;global $date_avancement;global $matricule;global $categorie;global $indice;global $num_bar;global $annee_40_ans; global $grade; global $classe; global $echelon;
//------ Etat de sommes dues période, retourne l'indice évolué
  // echo " ----- Date de début période=".$date_debut; echo " Date de fin de période=".$date_fin;echo " <br> ";
  // echo " ----- Categorie=".$categorie; echo " Indice=".$indice;echo " date avancement=".$date_avancement;echo " Matricule=".$matricule;echo    " <br> ";
  //echo "--------------".$annee_40_ans;
  //return; 
  while($date_avancement < $date_fin){
  // listing de tous les avancements
   //echo "<br>...début =".$date_debut." Fin =".datejourdown($date_avancement)." Avancement";
  //$salaire=salaire_base($categorie,$indice,$num_bar);
  if(($date_debut<=$annee_40_ans)&&($annee_40_ans<=$date_avancement)){
    echo "////////".$date_fin2 = $annee_40_ans;
    etat_sommes_dues_periode_bareme_avancement($date_debut,$annee_40_ans);
    $date_debut = datejourupdate($annee_40_ans);    
    $date_avancement = dateupdate($date_fin2);
    $annee_40_ans = "0000-00-00"; 
    if($categorie =="A1"){$categorie="A2";} 
    if($categorie=="B1"){$categorie="B2";}
    $indice = indice_suivant($indice,$categorie,$grade,$classe,$echelon);
    //$echelon = echelon_suivant($categorie,$grade,$classe,$echelon);
   }
   
  etat_sommes_dues_periode_bareme_avancement($date_debut, datejourdown($date_avancement)); 
  $date_debut = $date_avancement;
  $date_avancement = dateupdate($date_avancement);
  indice_suivant($indice,$categorie,$grade,$classe,$echelon);
  //echelon_suivant($categorie,$grade,$classe,$echelon);
  }
  //echo "<br>...début =".$date_debut." Fin $date_fin periode ou de bareme et Numero Bareme=$num_bar";
  etat_sommes_dues_periode_bareme_avancement($date_debut,$date_fin);
      
  return; 
}

function etat_sommes_dues_periode_bareme_contractuel($date_debut,$date_fin){
global $table_reversements;global $date_avancement;global $matricule;global $categorie;global $num_bar;global $annee_40_ans; global $grade; global $classe; global $echelon; global $i;
//------ Etat de sommes dues période, retourne l'indice évolué
  // echo " ----- Date de début période=".$date_debut; echo " Date de fin de période=".$date_fin;echo " <br> ";
  // echo " ----- Categorie=".$categorie; echo " Indice=".$indice;echo " date avancement=".$date_avancement;echo " Matricule=".$matricule;echo    " <br> ";
  //echo "--------------".$annee_40_ans;
  //return;
  $i = 1;
  while($date_avancement < $date_fin){
  // listing de tous les avancements
   //echo "<br>...début =".$date_debut." Fin =".datejourdown($date_avancement)." Avancement";
  //$salaire=salaire_base($categorie,$indice,$num_bar);
  if(($date_debut<=$annee_40_ans)&&($annee_40_ans<=$date_avancement)){
    echo "////////".$date_fin2 = $annee_40_ans;
    etat_sommes_dues_periode_bareme_avancement_contractuel($date_debut,$annee_40_ans);
    $date_debut = datejourupdate($annee_40_ans);    
    $date_avancement = dateupdate($date_fin2);
    $annee_40_ans = "0000-00-00"; 
    if($categorie =="01"){$categorie="02";} 
    if($categorie =="02"){$categorie="03";}
    if($categorie =="03"){$categorie="04";}
    if($categorie =="04"){$categorie="05";}
    if($categorie =="05"){$categorie="06";}
    if($categorie =="06"){$categorie="07";}
    if($categorie =="07"){$categorie="08";}
    if($categorie =="08"){$categorie="09";}
    if($categorie =="09"){$categorie="10";}
    if($categorie =="10"){$categorie="11";}
    if($categorie =="11"){$categorie="12";}
    $echelon = echelon_suivant($categorie,$echelon);
   }
  etat_sommes_dues_periode_bareme_avancement_contractuel($date_debut, datejourdown($date_avancement)); 
  $date_debut = $date_avancement;
  $date_avancement = dateupdate($date_avancement);
  echelon_suivant($categorie,$echelon);
  }
  //echo "<br>...début =".$date_debut." Fin $date_fin periode ou de bareme et Numero Bareme=$num_bar";
  etat_sommes_dues_periode_bareme_avancement_contractuel($date_debut,$date_fin);
      
  return; 
}

function etat_sommes_dues_periode_bareme_magis($date_debut,$date_fin){
global $table_reversements;global $date_avancement;global $matricule;global $categorie;global $num_bar;global $annee_40_ans; global $new_dd; global $grade; global $classe; global $echelon; global $indice;
//------ Etat de sommes dues période, retourne l'indice évolué
  // echo " ----- Date de début période=".$date_debut; echo " Date de fin de période=".$date_fin;echo " <br> ";
  // echo " ----- Categorie=".$categorie; echo " Indice=".$indice;echo " date avancement=".$date_avancement;echo " Matricule=".$matricule;echo    " <br> ";
  //echo "--------------".$annee_40_ans;
  //return;
  $i = 1;
  
  while($date_avancement < $date_fin){
  // listing de tous les avancements
   //echo "<br>...début =".$date_debut." Fin =".datejourdown($date_avancement)." Avancement";
  //$salaire=salaire_base($categorie,$indice,$num_bar);

    if($new_dd >= $date_debut && $new_dd <= $date_avancement){
      if(($date_debut<=$annee_40_ans)&&($annee_40_ans<=$new_dd)){
        echo "////////".$date_fin2 = $annee_40_ans;
        etat_sommes_dues_periode_bareme_avancement_magis($date_debut,$annee_40_ans);
        $date_debut = datejourupdate($annee_40_ans);    
        $new_dd = dateupdate($date_fin2);
        $annee_40_ans = "0000-00-00";
        $indice = indice_suivant_magis($indice,$matricule,$grade);
       }
    } else {
      if(($date_debut<=$annee_40_ans)&&($annee_40_ans<=$date_avancement)){
        echo "////////".$date_fin2 = $annee_40_ans;
        etat_sommes_dues_periode_bareme_avancement_magis($date_debut,$annee_40_ans);
        $date_debut = datejourupdate($annee_40_ans);    
        $date_avancement = dateupdate($date_fin2);
        $annee_40_ans = "0000-00-00";
       }
    }

   if($new_dd >= $date_debut && $new_dd <= $date_avancement){
    etat_sommes_dues_periode_bareme_avancement_magis($date_debut, datejourdown($new_dd)); 
    $date_debut = $new_dd;
    $new_dd = dateupdate($new_dd);
    indice_suivant_magis($indice,$matricule,$grade);
   } else {
      etat_sommes_dues_periode_bareme_avancement_magis($date_debut, datejourdown($date_avancement)); 
      $date_debut = $date_avancement;
      $date_avancement = dateupdate($date_avancement);
   }
  }
  //echo "<br>...début =".$date_debut." Fin $date_fin periode ou de bareme et Numero Bareme=$num_bar";
  etat_sommes_dues_periode_bareme_avancement_magis($date_debut,$date_fin);
      
  return; 
}

function etat_sommes_dues_periode_bareme2($date_debut,$date_fin){
global $table_reversements;global $date_avancement;global $matricule;global $categorie;global $indice;global $num_bar;global $annee_40_ans; global $categorie;
//------ Etat de sommes dues période, retourne l'indice évolué
  // echo " ----- Date de début période=".$date_debut; echo " Date de fin de période=".$date_fin;echo " <br> ";
  // echo " ----- Categorie=".$categorie; echo " Indice=".$indice;echo " date avancement=".$date_avancement;echo " Matricule=".$matricule;echo    " <br> ";
  //echo "--------------".$annee_40_ans;
  //return;
  while($date_avancement < $date_fin){
  // listing de tous les avancements
   //echo "<br>...début =".$date_debut." Fin =".datejourdown($date_avancement)." Avancement";
  //$salaire=salaire_base($categorie,$indice,$num_bar);
  if(($date_debut<=$annee_40_ans)&&($annee_40_ans<=$date_avancement)){
    echo "////////".$date_fin2 = $annee_40_ans;
    etat_sommes_dues_periode_bareme_avancement2($date_debut,$annee_40_ans);
    $date_debut = datejourupdate($annee_40_ans);    
    $date_avancement = dateupdate($date_fin2);
    $annee_40_ans = "0000-00-00"; 
    if($categorie =="A1"){$categorie="A2";} 
    if($categorie=="B1"){$categorie="B2";}
    $indice = indice_suivant($indice,$categorie);
   }
   
  etat_sommes_dues_periode_bareme_avancement2($date_debut, datejourdown($date_avancement)); 
  $date_debut = $date_avancement;
  $date_avancement = dateupdate($date_avancement);
  indice_suivant($indice,$categorie);
  }
  //echo "<br>...début =".$date_debut." Fin $date_fin periode ou de bareme et Numero Bareme=$num_bar";
  etat_sommes_dues_periode_bareme_avancement2($date_debut,$date_fin);
      
  return; 
}

function etat_sommes_dues_periode_bareme_gen($date_debut,$date_fin){
global $table_reversements;global $date_avancement;global $matricule;global $categorie;global $indice;global $num_bar;global $annee_40_ans; global $categorie; global $new_dd; global $grade; global $classe; global $echelon;
//------ Etat de sommes dues période, retourne l'indice évolué
  // echo " ----- Date de début période=".$date_debut; echo " Date de fin de période=".$date_fin;echo " <br> ";
  // echo " ----- Categorie=".$categorie; echo " Indice=".$indice;echo " date avancement=".$date_avancement;echo " Matricule=".$matricule;echo    " <br> ";
  //echo "--------------".$annee_40_ans;
  //return;
  $i = 1;

  while($date_avancement < $date_fin){
  // listing de tous les avancements
   //echo "<br>...début =".$date_debut." Fin =".datejourdown($date_avancement)." Avancement";
  //$salaire=salaire_base($categorie,$indice,$num_bar);

  if($categorie >= 01 && $categorie <= 12){
    if(($date_debut<=$annee_40_ans)&&($annee_40_ans<=$date_avancement)){
      echo "////////".$date_fin2 = $annee_40_ans;
      etat_sommes_dues_periode_bareme_avancement_contractuel_gen($date_debut,$annee_40_ans);
      $date_debut = datejourupdate($annee_40_ans);    
      $date_avancement = dateupdate($date_fin2);
      $annee_40_ans = "0000-00-00"; 

      if($categorie =="01"){$categorie="02";} 
      if($categorie =="02"){$categorie="03";}
      if($categorie =="03"){$categorie="04";}
      if($categorie =="04"){$categorie="05";}
      if($categorie =="05"){$categorie="06";}
      if($categorie =="06"){$categorie="07";}
      if($categorie =="07"){$categorie="08";}
      if($categorie =="08"){$categorie="09";}
      if($categorie =="09"){$categorie="10";}
      if($categorie =="10"){$categorie="11";}
      if($categorie =="11"){$categorie="12";}
      $echelon = echelon_suivant($categorie,$echelon);
    }
  } elseif ($categorie == 'MG') {
    if($new_dd >= $date_debut && $new_dd <= $date_avancement){
      if(($date_debut<=$annee_40_ans)&&($annee_40_ans<=$new_dd)){
        echo "////////".$date_fin2 = $annee_40_ans;
        etat_sommes_dues_periode_bareme_avancement_magis_gen($date_debut,$annee_40_ans);
        $date_debut = datejourupdate($annee_40_ans);    
        $new_dd = dateupdate($date_fin2);
        $annee_40_ans = "0000-00-00";
        $indice = indice_suivant_magis($indice,$matricule,$grade);
      }
    } else {
      if(($date_debut<=$annee_40_ans)&&($annee_40_ans<=$date_avancement)){
        echo "////////".$date_fin2 = $annee_40_ans;
        etat_sommes_dues_periode_bareme_avancement_magis($date_debut,$annee_40_ans);
        $date_debut = datejourupdate($annee_40_ans);    
        $date_avancement = dateupdate($date_fin2);
        $annee_40_ans = "0000-00-00";
       }
    }
  } else {
    if(($date_debut<=$annee_40_ans)&&($annee_40_ans<=$date_avancement)){
      echo "////////".$date_fin2 = $annee_40_ans;
      etat_sommes_dues_periode_bareme_avancement_gen($date_debut,$annee_40_ans);
      $date_debut = datejourupdate($annee_40_ans);    
      $date_avancement = dateupdate($date_fin2);
      $annee_40_ans = "0000-00-00"; 

      if($categorie =="A1"){$categorie="A2";} 
      if($categorie=="B1"){$categorie="B2";}
      $indice = indice_suivant($indice,$categorie);
    }
  }
   
  if($categorie >= 01 && $categorie <= 12){
    etat_sommes_dues_periode_bareme_avancement_contractuel_gen($date_debut, datejourdown($date_avancement)); 
    $date_debut = $date_avancement;
    $date_avancement = dateupdate($date_avancement);
    echelon_suivant($categorie,$echelon);
   } elseif($categorie == 'MG') {
      if($new_dd >= $date_debut && $new_dd <= $date_avancement){
        etat_sommes_dues_periode_bareme_avancement_magis_gen($date_debut, datejourdown($new_dd)); 
        $date_debut = $new_dd;
        $new_dd = dateupdate($new_dd);
        indice_suivant_magis($indice,$matricule,$grade);
     } else{
        etat_sommes_dues_periode_bareme_avancement_magis_gen($date_debut, datejourdown($date_avancement)); 
        $date_debut = $date_avancement;
        $date_avancement = dateupdate($date_avancement);
     }
   } else {
    etat_sommes_dues_periode_bareme_avancement_gen($date_debut, datejourdown($date_avancement)); 
    $date_debut = $date_avancement;
    $date_avancement = dateupdate($date_avancement);
    indice_suivant($indice,$categorie);
   }
  }
  if($categorie >= 01 && $categorie <= 12){
    //echo "<br>...début =".$date_debut." Fin $date_fin periode ou de bareme et Numero Bareme=$num_bar";
    etat_sommes_dues_periode_bareme_avancement_contractuel_gen($date_debut,$date_fin);
  } elseif($categorie == 'MG'){
    //echo "<br>...début =".$date_debut." Fin $date_fin periode ou de bareme et Numero Bareme=$num_bar";
    etat_sommes_dues_periode_bareme_avancement_magis_gen($date_debut,$date_fin);
  } else {
    //echo "<br>...début =".$date_debut." Fin $date_fin periode ou de bareme et Numero Bareme=$num_bar";
    etat_sommes_dues_periode_bareme_avancement_gen($date_debut,$date_fin);
  }
      
  return; 
}

function etat_sommes_dues_periode_bareme_avancement($date_debut,$date_fin){
global $dbc;global $ligne;global $ligne_new;global $categorie;global $indice;global $fin_bar; global $deb_bar;global $salaire;global $num_bar;
global $echelon; global $grade; global $classe;global $matricule;global $total;global $total_pat;global $total_fonc;global $total_verse;global $total_reliquat; global $i;
//-------------------- Récupération du l'échelon et de la classe

  $data1 = etatSommesDuesPeriodeBaremeAvancement($indice, $categorie, $num_bar);
    
  foreach($data1 as $etat){ // Etat de sommes dues d'un bareme
     $classe = $etat->CLASSE; 
     $echelon = $etat->ECHELON; 
  }
  //echo "Classe".$classe " and echel:".$echelon; 
// Calcul du salaire, et déduction de l'avancement et de l'indice suivant

  $salaire = salaire_base($categorie,$indice,$num_bar,$grade);
  $nbre_jours = Fdate($date_debut,$date_fin); 

  if($date_fin<("1991-07-01")){

    $taux = "18%";
    $taux1 = 0.18;
    $taux_fonc = "06%";
    $taux_fonc1 = 0.06;

  } else{

    $taux = "22%";
    $taux1 = 0.22;
    $taux_fonc = "10%";
    $taux_fonc1 = 0.10;    
  } 
  
  $taux_pat = 0.12; // Taux patronal
  $salaire_annuel = $salaire*12;
  $taux_new = $taux1*100;
  $calcul_pat = $salaire*$taux_pat*12*$nbre_jours/360;
  $calcul_fonc = $salaire*$taux_fonc1*12*$nbre_jours/360;
  $calcul = $calcul_fonc + $calcul_pat; 
  $total = $total+$calcul;
  $total_pat = $total_pat+$calcul_pat;
  $total_fonc = $total_fonc+$calcul_fonc;
  //$ligne.= '<div class="table-responsive"> <table  class="table table-hover table-bordered mt-4">';

  $ligne.= "<tr>
    <td>".date_fr($date_debut)." au <br>". date_fr($date_fin)."</td>
    <td>".date_fr($deb_bar)." au ". date_fr($fin_bar)."</td>
    <td align='center'>".$categorie." | ".$classe." | ".$echelon."</td>
    <td align='center'>".$indice."</td>
    <td align='center'>".$nbre_jours."</td>
    <td align='center'>".number_format(ceil($salaire), 0, ',', ' ')."</td>
    <td align='center'>".$taux_fonc."</td>
    <td align='center'>".number_format(ceil($calcul_fonc), 0, ',', ' ')."</td>
    <td align='center'>12%</td>
    <td align='center'>".number_format(ceil($calcul_pat), 0, ',', ' ')."</td>
    <td align='center'>".$taux."</td>
    <td align='center'>".number_format(ceil($calcul), 0, ',', ' ')."</td>
  </tr>";
  //-------------------  Ligne New
  // Montant cotisé pour la période
    $data2 = etatSommesDuesPeriodeBaremeAvancement2($matricule, $date_debut, $date_fin);
    foreach($data2 as $etat){
      $sum3_1 = $etat->cot_tot;
    };
  $averse = $sum3_1; 
  $reliquat = $calcul - $averse;
  $total_verse = $averse + $total_verse;
  $total_reliquat = $total_reliquat + $reliquat;
  //---
  $ligne_new.="<tr><td>".date_fr($date_debut)." au <br> ".date_fr($date_fin)." <br> soit ".$nbre_jours." jours</td>"; // Periode
  //$ligne.="<td>".date_fr($deb_bar,"fr")." au ". date_fr($fin_bar,"fr")."</td>"; // Barème   
  $ligne_new.="<td align='center'>".$indice."</td>";  
  $ligne_new.="<td align='center'><u>".number_format(ceil($salaire_annuel), 0, ',', '.')." x ".$taux_new." x ".$nbre_jours."</u><br>
  360 x 100 </td>"; 
  $ligne_new.=" <td align='right'> <b>".number_format(ceil($calcul), 0, ',', ' ')."</b></td> ";
  $ligne_new.="<td align='right'><b>".number_format(ceil($averse), 0, ',', ' ')."</b></td>";
  $ligne_new.=" <td align='right'> <b>".number_format(ceil($reliquat), 0, ',', ' ')."</b></td></tr>";
}

function etat_sommes_dues_periode_bareme_avancement_contractuel($date_debut,$date_fin){
global $dbc;global $ligne;global $ligne_new;global $categorie;global $fin_bar; global $deb_bar;global $salaire;global $num_bar;
global $echelon; global $grade; global $classe;global $matricule;global $total;global $total_pat;global $total_fonc;global $total_verse;global $total_reliquat;
//-------------------- Récupération du l'échelon et de la classe
  $data1 = etatSommesDuesPeriodeBaremeAvancementCon($grade, $categorie);
    
  foreach($data1 as $etat){ // Etat de sommes dues d'un bareme
     $grade = $etat->CODE_GRADE; 
  }

  //echo "Classe".$classe " and echel:".$echelon; 
// Calcul du salaire, et déduction de l'avancement et de l'indice suivant

  $salaire = salaire_base_contractuel($categorie,$echelon,$num_bar,$grade);
  $nbre_jours = Fdate($date_debut,$date_fin); 

  if($date_fin<("1991-07-01")){
    $taux = "10%";
    $taux1 = 0.10;
    $taux_fonc = "06%";
    $taux_fonc1 = 0.06;
  } else {
    $taux = "12%";
    $taux1 = 0.12;
    $taux_fonc = "10%";
    $taux_fonc1 = 0.10;
  } 
  
  $taux_pat = 0.12; // Taux patronal
  
  $salaire_annuel = $salaire*12;
  $taux_new = $taux1*100;
  $calcul_pat = $salaire*$taux_pat*12*$nbre_jours/360;
  $calcul_fonc = $salaire*$taux_fonc1*12*$nbre_jours/360;
  $calcul = $calcul_fonc + $calcul_pat; 
  $total = $total+$calcul;
  $total_pat = $total_pat+$calcul_pat;
  $total_fonc = $total_fonc+$calcul_fonc;
  //$ligne.= '<div class="table-responsive"> <table  class="table table-hover table-bordered mt-4">';

  $ligne.= "<tr>
    <td>".date_fr($date_debut)." au <br>". date_fr($date_fin)."</td>
    <td>".date_fr($deb_bar)." au ". date_fr($fin_bar)."</td>
    <td align='center'>".$grade." | ".$categorie."</td>
    <td align='center'>".$echelon."</td>
    <td align='center'>".$nbre_jours."</td>
    <td align='center'>".number_format(ceil($salaire), 0, ',', ' ')."</td>
    <td align='center'>".$taux_fonc."</td>
    <td align='center'>".number_format(ceil($calcul_fonc), 0, ',', ' ')."</td>
    <td align='center'>12%</td>
    <td align='center'>".number_format(ceil($calcul_pat), 0, ',', ' ')."</td>
    <td align='center'>".$taux."</td>
    <td align='center'>".number_format(ceil($calcul), 0, ',', ' ')."</td>
  </tr>";
  //-------------------  Ligne New
  // Montant cotisé pour la période
    $data2 = etatSommesDuesPeriodeBaremeAvancement2($matricule, $date_debut, $date_fin);
    foreach($data2 as $etat){
      $sum3_1 = $etat->cot_tot;
    };
  $averse = $sum3_1; 
  $reliquat = $calcul - $averse;
  $total_verse = $averse + $total_verse;
  $total_reliquat = $total_reliquat + $reliquat;
  //---
  $ligne_new.="<tr><td>".date_fr($date_debut)." au <br> ".date_fr($date_fin)." <br> soit ".$nbre_jours." jours</td>"; // Periode
  //$ligne.="<td>".date_fr($deb_bar,"fr")." au ". date_fr($fin_bar,"fr")."</td>"; // Barème   
  $ligne_new.="<td align='center'>".$echelon."</td>";  
  $ligne_new.="<td align='center'><u>".number_format(ceil($salaire_annuel), 0, ',', '.')." x ".$taux_new." x ".$nbre_jours."</u><br>
  360 x 100 </td>"; 
  $ligne_new.=" <td align='right'> <b>".number_format(ceil($calcul), 0, ',', ' ')."</b></td> ";
  $ligne_new.="<td align='right'><b>".number_format(ceil($averse), 0, ',', ' ')."</b></td>";
  $ligne_new.=" <td align='right'> <b>".number_format(ceil($reliquat), 0, ',', ' ')."</b></td></tr>";
}

function etat_sommes_dues_periode_bareme_avancement_magis($date_debut,$date_fin){
global $dbc;global $ligne;global $ligne_new;global $categorie;global $fin_bar; global $deb_bar;global $salaire;global $num_bar; global $indice;
global $echelon; global $grade; global $classe;global $matricule;global $total;global $total_pat;global $total_fonc;global $total_verse;global $total_reliquat;
//-------------------- Récupération du l'échelon et de la classe
  /*$data1 = etatSommesDuesPeriodeBaremeAvancementMagis($grade, $categorie);
    
  foreach($data1 as $etat){ // Etat de sommes dues d'un bareme
     $grade = $etat->CODE_GRADE; 
  }*/

  //echo "Classe".$classe " and echel:".$echelon; 
// Calcul du salaire, et déduction de l'avancement et de l'indice suivant

  $salaire = salaire_base_magis($indice,$num_bar,$grade);
  $nbre_jours = Fdate($date_debut,$date_fin); 

  if($date_fin<("1991-07-01")){

    $taux = "18%";
    $taux1 = 0.18;
    $taux_fonc = "06%";
    $taux_fonc1 = 0.06;

  } else{

    $taux = "22%";
    $taux1 = 0.22;
    $taux_fonc = "10%";
    $taux_fonc1 = 0.10;
    
  } 
  
  $taux_pat = 0.12; // Taux patronal
  $salaire_annuel = $salaire*12;
  $taux_new = $taux1*100;
  $calcul_pat = $salaire*$taux_pat*12*$nbre_jours/360;
  $calcul_fonc = $salaire*$taux_fonc1*12*$nbre_jours/360;
  $calcul = $calcul_fonc + $calcul_pat; 
  $total = $total+$calcul;
  $total_pat = $total_pat+$calcul_pat;
  $total_fonc = $total_fonc+$calcul_fonc;
  //$ligne.= '<div class="table-responsive"> <table  class="table table-hover table-bordered mt-4">';

  $ligne.= "<tr>
    <td>".date_fr($date_debut)." au <br>". date_fr($date_fin)."</td>
    <td>".date_fr($deb_bar)." au ". date_fr($fin_bar)."</td>
    <td align='center'>".$grade." | ".$categorie."</td>
    <td align='center'>".$indice."</td>
    <td align='center'>".$nbre_jours."</td>
    <td align='center'>".number_format(ceil($salaire), 0, ',', ' ')."</td>
    <td align='center'>".$taux_fonc."</td>
    <td align='center'>".number_format(ceil($calcul_fonc), 0, ',', ' ')."</td>
    <td align='center'>12%</td>
    <td align='center'>".number_format(ceil($calcul_pat), 0, ',', ' ')."</td>
    <td align='center'>".$taux."</td>
    <td align='center'>".number_format(ceil($calcul), 0, ',', ' ')."</td>
  </tr>";
  //-------------------  Ligne New
  // Montant cotisé pour la période
    $data2 = etatSommesDuesPeriodeBaremeAvancement2($matricule, $date_debut, $date_fin);
    foreach($data2 as $etat){
      $sum3_1 = $etat->cot_tot;
    };
  $averse = $sum3_1; 
  $reliquat = $calcul - $averse;
  $total_verse = $averse + $total_verse;
  $total_reliquat = $total_reliquat + $reliquat;
  //---
  $ligne_new.="<tr><td>".date_fr($date_debut)." au <br> ".date_fr($date_fin)." <br> soit ".$nbre_jours." jours</td>"; // Periode
  //$ligne.="<td>".date_fr($deb_bar,"fr")." au ". date_fr($fin_bar,"fr")."</td>"; // Barème   
  $ligne_new.="<td align='center'>".$indice."</td>";  
  $ligne_new.="<td align='center'><u>".number_format(ceil($salaire_annuel), 0, ',', '.')." x ".$taux_new." x ".$nbre_jours."</u><br>
  360 x 100 </td>"; 
  $ligne_new.=" <td align='right'> <b>".number_format(ceil($calcul), 0, ',', ' ')."</b></td> ";
  $ligne_new.="<td align='right'><b>".number_format(ceil($averse), 0, ',', ' ')."</b></td>";
  $ligne_new.=" <td align='right'> <b>".number_format(ceil($reliquat), 0, ',', ' ')."</b></td></tr>";
}

function etat_sommes_dues_periode_bareme_avancement_magis_gen($date_debut,$date_fin){
global $dbc;global $ligne;global $ligne_new;global $categorie;global $fin_bar; global $deb_bar;global $salaire;global $num_bar; global $indice;
global $echelon; global $grade; global $classe;global $matricule;global $total;global $total_pat;global $total_fonc;global $total_verse;global $total_reliquat;
//-------------------- Récupération du l'échelon et de la classe
  /*$data1 = etatSommesDuesPeriodeBaremeAvancementMagis($grade, $categorie);
    
  foreach($data1 as $etat){ // Etat de sommes dues d'un bareme
     $grade = $etat->CODE_GRADE; 
  }*/

  //echo "Classe".$classe " and echel:".$echelon; 
// Calcul du salaire, et déduction de l'avancement et de l'indice suivant

  $salaire = salaire_base_magis($indice,$num_bar,$grade);
  $nbre_jours = Fdate($date_debut,$date_fin); 

  if($date_fin<("1991-07-01")){

    $taux = "18%";
    $taux1 = 0.18;
    $taux_fonc = "06%";
    $taux_fonc1 = 0.06;

  } else{

    $taux = "22%";
    $taux1 = 0.22;
    $taux_fonc = "10%";
    $taux_fonc1 = 0.10;
    
  } 
  
  $taux_pat = 0.12; // Taux patronal
  $calcul = $salaire*$taux1*12*$nbre_jours/360; 
  $salaire_annuel = $salaire*12;
  $taux_new = $taux1*100;
  $calcul_pat = $salaire*$taux_pat*12*$nbre_jours/360;
  $calcul_fonc = $salaire*$taux_fonc1*12*$nbre_jours/360;
  $total = $total+$calcul;
  $total_pat = $total_pat+$calcul_pat;
  $total_fonc = $total_fonc+$calcul_fonc;

  //-------------------  Ligne New
  // Montant cotisé pour la période
    $data2 = etatSommesDuesPeriodeBaremeAvancement2($matricule, $date_debut, $date_fin);
    foreach($data2 as $etat){
      $sum3_1 = $etat->cot_tot;
    };
  $averse = $sum3_1; 
  $reliquat = $calcul - $averse;
  $total_verse = $averse + $total_verse;
  $total_reliquat = $total_reliquat + $reliquat;
  //---
  $ligne_new.="<tr><td class='table2T'>".date_fr($date_debut)." au <br> ".date_fr($date_fin)." <br> soit ".$nbre_jours." jours</td>"; // Periode
  //$ligne.="<td>".date_fr($deb_bar,"fr")." au ". date_fr($fin_bar,"fr")."</td>"; // Barème   
  $ligne_new.="<td align='center' class='table2T'>".$indice."</td>";  
  $ligne_new.="<td align='center' class='table2T'><u>".number_format(ceil($salaire_annuel), 0, ',', '.')." x ".$taux_new." x ".$nbre_jours."</u><br>
  360 x 100 </td>"; 
  $ligne_new.=" <td align='center' class='table2T'> <b>".number_format(ceil($calcul), 0, ',', ' ')."</b></td> ";
  $ligne_new.="<td align='center' class='table2T'><b>".number_format(ceil($averse), 0, ',', ' ')."</b></td>";
  $ligne_new.=" <td align='center' class='table2T'> <b>".number_format(ceil($reliquat), 0, ',', ' ')."</b></td></tr>";
}

function etat_sommes_dues_periode_bareme_avancement2($date_debut,$date_fin){
global $dbc;global $ligne;global $ligne_new;global $categorie;global $indice;global $fin_bar; global $deb_bar;global $salaire;global $num_bar;
global $echelon; global $grade; global $classe;global $matricule;global $total;global $total_pat;global $total_fonc;global $total_verse;global $total_reliquat;
//-------------------- Récupération du l'échelon et de la classe


  $data1 = etatSommesDuesPeriodeBaremeAvancement($indice, $grade, 'BF20');
    
  foreach($data1 as $etat){ // Etat de sommes dues d'un bareme
     $classe = $etat->ech_sol; 
     $echelon = substr(($echelon11 = $etat->ech_sol),2,3); 
  }
  //echo "Classe".$classe " and echel:".$echelon; 
// Calcul du salaire, et déduction de l'avancement et de l'indice suivant

  $salaire=salaire_base($categorie,$indice,$num_bar,$grade,$classe,$echelon);
  $nbre_jours=Fdate($date_debut,$date_fin); 
  if ($date_fin<("1991-07-01")){$taux="18%";$taux1=0.18;$taux_fonc="06%";$taux_fonc1=0.06;}else{$taux="22%";$taux1=0.22;$taux_fonc="10%";$taux_fonc1=0.10;} 
  $taux_pat=0.12; // Taux patronal
  $calcul=$salaire*$taux1*12*$nbre_jours/360; $salaire_annuel=$salaire*12;$taux_new=$taux1*100;
  $calcul_pat=$salaire*$taux_pat*12*$nbre_jours/360;
  $calcul_fonc=$salaire*$taux_fonc1*12*$nbre_jours/360;
  $total=$total+$calcul;$total_pat=$total_pat+$calcul_pat;$total_fonc=$total_fonc+$calcul_fonc;
  //$ligne.= '<div class="table-responsive"> <table  class="table table-hover table-bordered mt-4">';

  //-------------------  Ligne New
  // Montant cotisé pour la période
    $data2 = etatSommesDuesPeriodeBaremeAvancement2($matricule, $date_debut, $date_fin);
    foreach($data2 as $etat){
      $sum3_1 = $etat->cot_tot;
    };
  $averse = $sum3_1; 
  $reliquat = $calcul - $averse;
  $total_verse = $averse + $total_verse;
  $total_reliquat = $total_reliquat + $reliquat;
  //---
  $ligne_new.="<tr><td class='table2T'>".date_fr($date_debut)." au <br> ".date_fr($date_fin)." <br> soit ".$nbre_jours." jours</td>"; // Periode
  //$ligne.="<td>".date_fr($deb_bar,"fr")." au ". date_fr($fin_bar,"fr")."</td>"; // Barème   
  $ligne_new.="<td align='center' class='table2T'>".$indice."</td>";  
  $ligne_new.="<td align='center' class='table2T'><u>".number_format(ceil($salaire_annuel), 0, ',', '.')." x ".$taux_new." x ".$nbre_jours."</u><br>
  360 x 100 </td>"; 
  $ligne_new.=" <td align='center' class='table2T'> <b>".number_format(ceil($calcul), 0, ',', ' ')."</b></td> ";
  $ligne_new.="<td align='center' class='table2T'><b>".number_format(ceil($averse), 0, ',', ' ')."</b></td>";
  $ligne_new.=" <td align='center' class='table2T'> <b>".number_format(ceil($reliquat), 0, ',', ' ')."</b></td></tr>";
}

function etat_sommes_dues_periode_bareme_avancement_gen($date_debut,$date_fin){
global $dbc;global $ligne;global $ligne_new;global $categorie;global $indice;global $fin_bar; global $deb_bar;global $salaire;global $num_bar;
global $echelon; global $grade; global $classe;global $matricule;global $total;global $total_pat;global $total_fonc;global $total_verse;global $total_reliquat; global $i;
//-------------------- Récupération du l'échelon et de la classe

  $data1 = etatSommesDuesPeriodeBaremeAvancement($indice, $categorie, $num_bar);
    
  foreach($data1 as $etat){ // Etat de sommes dues d'un bareme
     $classe = $etat->CLASSE; 
     $echelon = $etat->ECHELON; 
  }
  //echo "Classe".$classe " and echel:".$echelon; 
// Calcul du salaire, et déduction de l'avancement et de l'indice suivant

  $salaire = salaire_base($categorie,$indice,$num_bar,$grade);
  $nbre_jours = Fdate($date_debut,$date_fin); 

  if ($date_fin<("1991-07-01")){$taux="18%";$taux1=0.18;$taux_fonc="06%";$taux_fonc1=0.06;}else{$taux="22%";$taux1=0.22;$taux_fonc="10%";$taux_fonc1=0.10;} 
  $taux_pat=0.12; // Taux patronal
  $calcul=$salaire*$taux1*12*$nbre_jours/360; $salaire_annuel=$salaire*12;$taux_new=$taux1*100;
  $calcul_pat=$salaire*$taux_pat*12*$nbre_jours/360;
  $calcul_fonc=$salaire*$taux_fonc1*12*$nbre_jours/360;
  $total=$total+$calcul;$total_pat=$total_pat+$calcul_pat;$total_fonc=$total_fonc+$calcul_fonc;
  //$ligne.= '<div class="table-responsive"> <table  class="table table-hover table-bordered mt-4">';

  //-------------------  Ligne New
  // Montant cotisé pour la période
    $data2 = etatSommesDuesPeriodeBaremeAvancement2($matricule, $date_debut, $date_fin);
    foreach($data2 as $etat){
      $sum3_1 = $etat->cot_tot;
    };
  $averse = $sum3_1; 
  $reliquat = $calcul - $averse;
  $total_verse = $averse + $total_verse;
  $total_reliquat = $total_reliquat + $reliquat;
  //---
  $ligne_new.="<tr><td class='table2T'>".date_fr($date_debut)." au <br> ".date_fr($date_fin)." <br> soit ".$nbre_jours." jours</td>"; // Periode
  //$ligne.="<td>".date_fr($deb_bar,"fr")." au ". date_fr($fin_bar,"fr")."</td>"; // Barème   
  $ligne_new.="<td align='center' class='table2T'>".$indice."</td>";  
  $ligne_new.="<td align='center' class='table2T'><u>".number_format(ceil($salaire_annuel), 0, ',', '.')." x ".$taux_new." x ".$nbre_jours."</u><br>
  360 x 100 </td>"; 
  $ligne_new.=" <td align='center' class='table2T'> <b>".number_format(ceil($calcul), 0, ',', ' ')."</b></td> ";
  $ligne_new.="<td align='center' class='table2T'><b>".number_format(ceil($averse), 0, ',', ' ')."</b></td>";
  $ligne_new.=" <td align='center' class='table2T'> <b>".number_format(ceil($reliquat), 0, ',', ' ')."</b></td></tr>";
}

function etat_sommes_dues_periode_bareme_avancement_contractuel_gen($date_debut,$date_fin){
global $dbc;global $ligne;global $ligne_new;global $categorie;global $indice;global $fin_bar; global $deb_bar;global $salaire;global $num_bar;
global $echelon; global $grade; global $classe;global $matricule;global $total;global $total_pat;global $total_fonc;global $total_verse;global $total_reliquat; global $i;
//-------------------- Récupération du l'échelon et de la classe
  $data1 = etatSommesDuesPeriodeBaremeAvancementCon($grade, $categorie);
    
  foreach($data1 as $etat){ // Etat de sommes dues d'un bareme
     $grade = $etat->CODE_GRADE; 
  }

  //echo "Classe".$classe " and echel:".$echelon; 
// Calcul du salaire, et déduction de l'avancement et de l'indice suivant

  $salaire = salaire_base_contractuel($categorie,$echelon,$num_bar,$grade);
  $nbre_jours = Fdate($date_debut,$date_fin); 

  if($date_fin<("1991-07-01")){
    $taux = "10%";
    $taux1 = 0.10;
    $taux_fonc = "06%";
    $taux_fonc1 = 0.06;
  } else {
    $taux = "12%";
    $taux1 = 0.12;
    $taux_fonc = "10%";
    $taux_fonc1 = 0.10;
  } 
  
  $taux_pat = 0.12; // Taux patronal
  $calcul = $salaire*$taux1*12*$nbre_jours/360; 
  $salaire_annuel = $salaire*12;
  $taux_new = $taux1*100;
  $calcul_pat = $salaire*$taux_pat*12*$nbre_jours/360;
  $calcul_fonc = $salaire*$taux_fonc1*12*$nbre_jours/360;
  $total = $total+$calcul;
  $total_pat = $total_pat+$calcul_pat;
  $total_fonc = $total_fonc+$calcul_fonc;
  //-------------------  Ligne New
  // Montant cotisé pour la période
    $data2 = etatSommesDuesPeriodeBaremeAvancement2($matricule, $date_debut, $date_fin);
    foreach($data2 as $etat){
      $sum3_1 = $etat->cot_tot;
    };
  $averse = $sum3_1; 
  $reliquat = $calcul - $averse;
  $total_verse = $averse + $total_verse;
  $total_reliquat = $total_reliquat + $reliquat;
  //---
  $ligne_new.="<tr><td class='table2T'>".date_fr($date_debut)." au <br> ".date_fr($date_fin)." <br> soit ".$nbre_jours." jours</td>"; // Periode
  //$ligne.="<td>".date_fr($deb_bar,"fr")." au ". date_fr($fin_bar,"fr")."</td>"; // Barème   
  $ligne_new.="<td align='center' class='table2T'>".$indice."</td>";  
  $ligne_new.="<td align='center' class='table2T'><u>".number_format(ceil($salaire_annuel), 0, ',', '.')." x ".$taux_new." x ".$nbre_jours."</u><br>
  360 x 100 </td>"; 
  $ligne_new.=" <td align='center' class='table2T'> <b>".number_format(ceil($calcul), 0, ',', ' ')."</b></td> ";
  $ligne_new.="<td align='center' class='table2T'><b>".number_format(ceil($averse), 0, ',', ' ')."</b></td>";
  $ligne_new.=" <td align='center' class='table2T'> <b>".number_format(ceil($reliquat), 0, ',', ' ')."</b></td></tr>";
}

function etat_sommes_dues_periode($date_debut,$date_fin){
  global $matricule; 
global $categorie;global $indice;global $table_reversements;global $date_avancement;global $matricule;global $dbc;
global $fin_bar; global $deb_bar;global $echelon;global $salaire;global $num_bar;
//------ Etat de sommes dues période, retourne l'indice évolué
//echo " Categorie=".$categorie; echo " Indicez=".$indice;echo " date avancement=".$date_avancement;echo " Matricule=".$matricule;

  // recherche liste de baremes

  while($date_debut < $date_fin){

    $data = etatSommesDuesPeriode($date_fin,$date_debut);

    $calcul = 0; 
    $boucle = 0;

    foreach($data as $etat){ // Etat de sommes dues d'un bareme

      $num_bar = $etat->num_bar;
      $fin_bar = $etat->dat_fin; 
      $deb_bar = $etat->dat_deb; 
      //$date_fin=$fin_bar;;
      // echo "<br>+Numero bareme=".$num_bar."  / Date de début bareme=".$deb_bar."  / Date de fin bareme=".$fin_bar." / Date de Fin =".$date_fin."//<br>";   
      if($date_fin < $fin_bar){
        etat_sommes_dues_periode_bareme($date_debut,$date_fin);
      } else {
        etat_sommes_dues_periode_bareme($date_debut,$fin_bar);
      }   
      $date_debut = datejourupdate($fin_bar);
    }
  }
  return;
} 

function etat_sommes_dues_periode_contractuel($date_debut,$date_fin){
  global $matricule; 
global $categorie;global $table_reversements;global $date_avancement;global $matricule;global $dbc;
global $fin_bar; global $deb_bar;global $echelon; global $grade; global $salaire;global $num_bar;
//------ Etat de sommes dues période, retourne l'indice évolué
//echo " Categorie=".$categorie; echo " Indicez=".$indice;echo " date avancement=".$date_avancement;echo " Matricule=".$matricule;

  // recherche liste de baremes

  while($date_debut < $date_fin){

    $data = etatSommesDuesPeriode($date_fin,$date_debut);

    $calcul = 0; 
    $boucle = 0;

    foreach($data as $etat){ // Etat de sommes dues d'un bareme

      $num_bar = $etat->num_bar;
      $fin_bar = $etat->dat_fin; 
      $deb_bar = $etat->dat_deb; 
      //$date_fin=$fin_bar;;
      // echo "<br>+Numero bareme=".$num_bar."  / Date de début bareme=".$deb_bar."  / Date de fin bareme=".$fin_bar." / Date de Fin =".$date_fin."//<br>";   
      if($date_fin < $fin_bar){
        etat_sommes_dues_periode_bareme_contractuel($date_debut,$date_fin);
      } else {
        etat_sommes_dues_periode_bareme_contractuel($date_debut,$fin_bar);
      }   
      $date_debut = datejourupdate($fin_bar);
    }
  }
  return;
}

function etat_sommes_dues_periode_magis($date_debut,$date_fin){
  global $matricule; 
global $categorie;global $table_reversements;global $date_avancement;global $matricule;global $dbc;
global $fin_bar; global $new_dd; global $deb_bar;global $echelon; global $grade; global $salaire;global $num_bar;
//------ Etat de sommes dues période, retourne l'indice évolué
//echo " Categorie=".$categorie; echo " Indicez=".$indice;echo " date avancement=".$date_avancement;echo " Matricule=".$matricule;

  // recherche liste de baremes

  while($date_debut < $date_fin){

    $res = getNewStartDateMagis($matricule,$grade);
    $new_dd = $res->date_effet;

    $data = etatSommesDuesPeriode($date_fin,$date_debut);

    $calcul = 0; 
    $boucle = 0;

    foreach($data as $etat){ // Etat de sommes dues d'un bareme

      $num_bar = $etat->num_bar;
      $fin_bar = $etat->dat_fin; 
      $deb_bar = $etat->dat_deb; 

      //$date_fin=$fin_bar;;
      // echo "<br>+Numero bareme=".$num_bar."  / Date de début bareme=".$deb_bar."  / Date de fin bareme=".$fin_bar." / Date de Fin =".$date_fin."//<br>";   

      if($date_fin < $fin_bar){
        etat_sommes_dues_periode_bareme_magis($date_debut,$date_fin);
      } else {
        etat_sommes_dues_periode_bareme_magis($date_debut,$fin_bar);
      }
        $date_debut = datejourupdate($fin_bar);   
    }
  }
  return;
} 

function etat_sommes_dues_periode2($date_debut,$date_fin){
  global $matricule; 
global $categorie;global $indice;global $table_reversements;global $date_avancement;global $matricule;global $dbc;
global $fin_bar; global $deb_bar;global $indice;global $salaire;global $num_bar;
//------ Etat de sommes dues période, retourne l'indice évolué
//echo " Categorie=".$categorie; echo " Indicez=".$indice;echo " date avancement=".$date_avancement;echo " Matricule=".$matricule;

  // recherche liste de baremes

  while($date_debut < $date_fin){

    $data = etatSommesDuesPeriode($date_fin,$date_debut);

    $calcul = 0; 
    $boucle = 0;

    foreach($data as $etat){ // Etat de sommes dues d'un bareme

      $num_bar = $etat->num_bar;
      $fin_bar = $etat->dat_fin; 
      $deb_bar = $etat->dat_deb; 
      //$date_fin=$fin_bar;;
      // echo "<br>+Numero bareme=".$num_bar."  / Date de début bareme=".$deb_bar."  / Date de fin bareme=".$fin_bar." / Date de Fin =".$date_fin."//<br>";   
      if($date_fin < $fin_bar){
        etat_sommes_dues_periode_bareme2($date_debut,$date_fin);
      } else {
        etat_sommes_dues_periode_bareme2($date_debut,$fin_bar);
      }   
      $date_debut = datejourupdate($fin_bar);
    }
  }
  return;
}

function etat_sommes_dues_periode_gen($date_debut,$date_fin){
  global $matricule; 
global $categorie;global $indice;global $table_reversements;global $date_avancement;global $matricule;global $dbc; global $new_dd; global $fin_bar; global $deb_bar;global $indice;global $salaire;global $num_bar; global $echelon; global $grade;
//------ Etat de sommes dues période, retourne l'indice évolué
//echo " Categorie=".$categorie; echo " Indicez=".$indice;echo " date avancement=".$date_avancement;echo " Matricule=".$matricule;

  // recherche liste de baremes

  while($date_debut < $date_fin){

    if($categorie == 'MG') {
      $res = getNewStartDateMagis($matricule,$grade);
      $new_dd = $res->date_effet;
    }

    $data = etatSommesDuesPeriode($date_fin,$date_debut);

    $calcul = 0; 
    $boucle = 0;

    foreach($data as $etat){ // Etat de sommes dues d'un bareme

      $num_bar = $etat->num_bar;
      $fin_bar = $etat->dat_fin; 
      $deb_bar = $etat->dat_deb; 
      //$date_fin=$fin_bar;;
      // echo "<br>+Numero bareme=".$num_bar."  / Date de début bareme=".$deb_bar."  / Date de fin bareme=".$fin_bar." / Date de Fin =".$date_fin."//<br>";   
      if($date_fin < $fin_bar){
        etat_sommes_dues_periode_bareme_gen($date_debut,$date_fin);
      } else {
        etat_sommes_dues_periode_bareme_gen($date_debut,$fin_bar);
      }   
      $date_debut = datejourupdate($fin_bar);
    }
  }
  return;
} 

function etat_sommes_dues($grad, $class, $echl, $cat,$ind,$date_debut,$date_fin,$date_avcmnt,$date_naiss){
//------ Variables 
global $num_bar; global $annee_40_ans;
global $bareme;
global $nbj;
global $salaire;
global $nbm;
global $nba;
global $indice;
global $categorie;
global $table_reversements;global $ligne;global $ligne_new;
global $date_avancement;
global $matricule; 

global $naiss; 
global $total;
global $total_pat;
global $total_fonc;
global $grade;
global $classe;
global $echelon;
global $total_cotisations;

$sal = 0;
global $total_verse;
global $total_reliquat; 
$date_avancement = $date_avcmnt;

//---------------------------------------------------------------------------------------
$ligne = '<table class="table table-hover table-light table-striped table-bordered table-sm mt-3" id="reversements">
  <tr>
    <td colspan="12" class="text-center font-weight-bold p-2">REVERSEMENTS A EFFECTUER</td>
  </tr>
  <tr class="text-center">
    <th>Période</th>
    <th>Barème</th>
    <th>Avancements</th>
    <th>Indice</th>
    <th>Jours</th>
    <th>Salaire de Base</th>
    <th>Taux Salarié</th>
    <th>Rev.Salarié</th>
    <th>Taux Pat</th>
    <th>Rev.Patronal</th>
    <th>Taux</th>
    <th>Reversements</th>
  </tr>';

/*$ligne='<div class="table-responsive"> <table  class="table table-hover table-bordered mt-4">
<tr><td align="center" colspan="12"><span class="art-postheadericon"><b>REVERSEMENTS A EFFECTUER </b></span></td></tr>
<tr>
<td><b>Période</b></td><td><b>Barème</b></td><td><b>Avancements</b></td><td><b>Indice</b></td><td><b> Jours</b></td> <td><b>Salaire de Base</b></td><td><b>Taux Salarié</b></td><td<b>Rev. Salarié</b></td><td ><b>Taux Pat </b></td><td><b>Rev. Patronal</b></td><td><b>Taux </b></td><td > <b>Reversements</b></td> </tr>';*/

$ligne_new ='<div class="table-responsive"><table class="table table-hover table-light table-striped table-bordered table-sm mt-3">
<td><b>Période</b></td><td><b>Indice</b></td><td><b>Décompte 18% et 22%</b></td><td><b>Aurait dû verser </b></td><td><b> A Versé</b></td> <td><b>Reliquat dû</b></td></tr>';

$categorie = $cat; 
$indice = $ind;
$grade = $grad;
$classe = $class;
$echelon = $echl;
$date_avancement = $date_avcmnt;
$matricule = $matricule;
$naiss = $date_naiss;
$total = 0;
$total_pat = 0 ;
$total_fonct = 0;

  if(($date_debut<("1991-07-01"))&&($date_fin>("1991-07-01"))){
    etat_sommes_dues_periode($date_debut,"1991-06-30");
    etat_sommes_dues_periode("1991-07-01",$date_fin); 
    
  }else{
     
    etat_sommes_dues_periode($date_debut,$date_fin);  
  }
$ligne.="<tr><td align='left' colspan='7'><b>TOTAL</b></td> <td align='right'> <b>".number_format(ceil($total_fonc), 0, ',', ' ')."</b></td>"; 
$ligne.="<td align='left' ><b></b></td> <td align='right'> <b>".number_format(ceil($total_pat), 0, ',', ' ')."</b></td>";    

  $ligne.="<td align='left' ><b></b></td> <td align='right'> <b>".number_format(ceil($total), 0, ',', ' ')."</b></td> </tr></div></table>"; 
 //return;

//---- Verification des cotisations effectuées hors période de détachement
  $etatSD = etat_cotisations($matricule, $date_fin);

  foreach($etatSD as $etat){  

    $date_debut = $etat->dat_deb_cot;
    $date_fin = $etat->dat_fin_cot; 
    $averse = $etat->cot_tot;
    $calcul = 0;
    $reliquat = $calcul - $averse ; //$averse-$calcul;
    $ligne_new.="<tr><td>".date_fr($date_debut)." au <br> ". date_fr($date_fin)." <br> Fin de Détachement </td>";
  $ligne_new.="<td align='center'>".$indice."</td>";   
  $ligne_new.="<td align='center'><u>Regularisation</u><br> </td><td align='right'> <b>".$calcul."</b></td> ";
  $ligne_new.="<td align='right'><b>".number_format(ceil($averse), 0, ',', ' ')."</b></td>";  
  $ligne_new.=" <td align='right'> <b>".number_format(ceil($reliquat), 0, ',', ' ')."</b></td></tr>";
  $total_verse = $averse + $total_verse;
  $total_reliquat = $total_reliquat + $reliquat;
    } 
return $total;
}

function etat_sommes_dues_contractuel($grad, $echl, $cat, $date_debut,$date_fin,$date_avcmnt,$date_naiss){
//------ Variables 
global $num_bar; global $annee_40_ans;
global $bareme;
global $nbj;
global $salaire;
global $nbm;
global $nba;
global $categorie;
global $table_reversements;global $ligne;global $ligne_new;
global $date_avancement;
global $matricule; 

global $naiss; 
global $total;
global $total_pat;
global $total_fonc;
global $grade;
global $echelon;
global $total_cotisations;

$sal = 0;
global $total_verse;
global $total_reliquat; 
$date_avancement = $date_avcmnt;

//---------------------------------------------------------------------------------------
$ligne = '<table class="table table-hover table-light table-striped table-bordered table-sm mt-3" id="reversements">
  <tr>
    <td colspan="12" class="text-center font-weight-bold p-2">REVERSEMENTS A EFFECTUER</td>
  </tr>
  <tr class="text-center">
    <th>Période</th>
    <th>Barème</th>
    <th>Avancements</th>
    <th>Echelon</th>
    <th>Jours</th>
    <th>Salaire de Base</th>
    <th>Taux Salarié</th>
    <th>Rev.Salarié</th>
    <th>Taux Pat</th>
    <th>Rev.Patronal</th>
    <th>Taux</th>
    <th>Reversements</th>
  </tr>';

/*$ligne='<div class="table-responsive"> <table  class="table table-hover table-bordered mt-4">
<tr><td align="center" colspan="12"><span class="art-postheadericon"><b>REVERSEMENTS A EFFECTUER </b></span></td></tr>
<tr>
<td><b>Période</b></td><td><b>Barème</b></td><td><b>Avancements</b></td><td><b>Indice</b></td><td><b> Jours</b></td> <td><b>Salaire de Base</b></td><td><b>Taux Salarié</b></td><td<b>Rev. Salarié</b></td><td ><b>Taux Pat </b></td><td><b>Rev. Patronal</b></td><td><b>Taux </b></td><td > <b>Reversements</b></td> </tr>';*/

$ligne_new ='<div class="table-responsive"><table class="table table-hover table-light table-striped table-bordered table-sm mt-3">
<td><b>Période</b></td><td><b>Indice</b></td><td><b>Décompte 18% et 22%</b></td><td><b>Aurait dû verser </b></td><td><b> A Versé</b></td> <td><b>Reliquat dû</b></td></tr>';

$categorie = $cat; 
$grade = $grad;
$echelon = $echl;
$date_avancement = $date_avcmnt;
$matricule = $matricule;
$naiss = $date_naiss;
$total = 0;
$total_pat = 0 ;
$total_fonct = 0;

  if(($date_debut<("1991-07-01"))&&($date_fin>("1991-07-01"))){
    etat_sommes_dues_periode_contractuel($date_debut,"1991-06-30");
    etat_sommes_dues_periode_contractuel("1991-07-01",$date_fin); 
    
  }else{
     
    etat_sommes_dues_periode_contractuel($date_debut,$date_fin);  
  }
$ligne.="<tr><td align='left' colspan='7'><b>TOTAL</b></td> <td align='right'> <b>".number_format(ceil($total_fonc), 0, ',', ' ')."</b></td>"; 
$ligne.="<td align='left' ><b></b></td> <td align='right'> <b>".number_format(ceil($total_pat), 0, ',', ' ')."</b></td>";    

  $ligne.="<td align='left' ><b></b></td> <td align='right'> <b>".number_format(ceil($total), 0, ',', ' ')."</b></td> </tr></div></table>"; 
 //return;

//---- Verification des cotisations effectuées hors période de détachement
  $etatSD = etat_cotisations($matricule, $date_fin);

  foreach($etatSD as $etat){  

    $date_debut = $etat->dat_deb_cot;
    $date_fin = $etat->dat_fin_cot; 
    $averse = $etat->cot_tot;
    $calcul = 0;
    $reliquat = $calcul - $averse ; //$averse-$calcul;
    $ligne_new.="<tr><td>".date_fr($date_debut)." au <br> ". date_fr($date_fin)." <br> Fin de Détachement </td>";
  $ligne_new.="<td align='center'>".$indice."</td>";   
  $ligne_new.="<td align='center'><u>Regularisation</u><br> </td><td align='right'> <b>".$calcul."</b></td> ";
  $ligne_new.="<td align='right'><b>".number_format(ceil($averse), 0, ',', ' ')."</b></td>";  
  $ligne_new.=" <td align='right'> <b>".number_format(ceil($reliquat), 0, ',', ' ')."</b></td></tr>";
  $total_verse = $averse + $total_verse;
  $total_reliquat = $total_reliquat + $reliquat;
    } 
return $total;
}

function etat_sommes_dues_magis($mat, $grad, $echl, $cat, $ind, $date_debut,$date_fin,$date_avcmnt,$date_naiss){
//------ Variables 
global $num_bar; global $annee_40_ans;
global $bareme;
global $nbj;
global $salaire;
global $nbm;
global $nba;
global $categorie;
global $table_reversements;global $ligne;global $ligne_new;
global $date_avancement;
global $matricule; 

global $naiss; 
global $total;
global $total_pat;
global $total_fonc;
global $grade;
global $echelon;
global $total_cotisations;

$sal = 0;
global $total_verse;
global $total_reliquat; 
$date_avancement = $date_avcmnt;

//---------------------------------------------------------------------------------------
$ligne = '<table class="table table-hover table-light table-striped table-bordered table-sm mt-3" id="reversements">
  <tr>
    <td colspan="12" class="text-center font-weight-bold p-2">REVERSEMENTS A EFFECTUER</td>
  </tr>
  <tr class="text-center">
    <th>Période</th>
    <th>Barème</th>
    <th>Avancements</th>
    <th>Indice</th>
    <th>Jours</th>
    <th>Salaire de Base</th>
    <th>Taux Salarié</th>
    <th>Rev.Salarié</th>
    <th>Taux Pat</th>
    <th>Rev.Patronal</th>
    <th>Taux</th>
    <th>Reversements</th>
  </tr>';

/*$ligne='<div class="table-responsive"> <table  class="table table-hover table-bordered mt-4">
<tr><td align="center" colspan="12"><span class="art-postheadericon"><b>REVERSEMENTS A EFFECTUER </b></span></td></tr>
<tr>
<td><b>Période</b></td><td><b>Barème</b></td><td><b>Avancements</b></td><td><b>Indice</b></td><td><b> Jours</b></td> <td><b>Salaire de Base</b></td><td><b>Taux Salarié</b></td><td<b>Rev. Salarié</b></td><td ><b>Taux Pat </b></td><td><b>Rev. Patronal</b></td><td><b>Taux </b></td><td > <b>Reversements</b></td> </tr>';*/

$ligne_new ='<div class="table-responsive"><table class="table table-hover table-light table-striped table-bordered table-sm mt-3">
<td><b>Période</b></td><td><b>Indice</b></td><td><b>Décompte 18% et 22%</b></td><td><b>Aurait dû verser </b></td><td><b> A Versé</b></td> <td><b>Reliquat dû</b></td></tr>';

$categorie = $cat; 
$indice = $ind;
$grade = $grad;
$echelon = $echl;
$date_avancement = $date_avcmnt;
$matricule = $mat;
$naiss = $date_naiss;
$total = 0;
$total_pat = 0 ;
$total_fonct = 0;

  if(($date_debut<("1991-07-01"))&&($date_fin>("1991-07-01"))){
    etat_sommes_dues_periode_magis($date_debut,"1991-06-30");
    etat_sommes_dues_periode_magis("1991-07-01",$date_fin); 
    
  }else{
    etat_sommes_dues_periode_magis($date_debut,$date_fin);  
  }
$ligne.="<tr><td align='left' colspan='7'><b>TOTAL</b></td> <td align='right'> <b>".number_format(ceil($total_fonc), 0, ',', ' ')."</b></td>"; 
$ligne.="<td align='left' ><b></b></td> <td align='right'> <b>".number_format(ceil($total_pat), 0, ',', ' ')."</b></td>";    

  $ligne.="<td align='left' ><b></b></td> <td align='right'> <b>".number_format(ceil($total), 0, ',', ' ')."</b></td> </tr></div></table>"; 
 //return;

//---- Verification des cotisations effectuées hors période de détachement
  $etatSD = etat_cotisations($matricule, $date_fin);

  foreach($etatSD as $etat){  

    $date_debut = $etat->dat_deb_cot;
    $date_fin = $etat->dat_fin_cot; 
    $averse = $etat->cot_tot;
    $calcul = 0;
    $reliquat = $calcul - $averse ; //$averse-$calcul;

    $ligne_new.="<tr><td>".date_fr($date_debut)." au <br> ". date_fr($date_fin)." <br> Fin de Détachement </td>";
    $ligne_new.="<td align='center'>".$indice."</td>";   
    $ligne_new.="<td align='center'><u>Regularisation</u><br> </td><td align='right'> <b>".$calcul."</b></td> ";
    $ligne_new.="<td align='right'><b>".number_format(ceil($averse), 0, ',', ' ')."</b></td>";  
    $ligne_new.=" <td align='right'> <b>".number_format(ceil($reliquat), 0, ',', ' ')."</b></td></tr>";
    $total_verse = $averse + $total_verse;
    $total_reliquat = $total_reliquat + $reliquat;
    } 
return $total;
}

function etat_sommes_dues2($cat,$ind,$date_debut,$date_fin,$date_avcmnt,$date_naiss){
//------ Variables 
global $num_bar; global $annee_40_ans;
global $bareme;
global $nbj;
global $salaire;
global $nbm;
global $nba;
global $indice;
global $categorie;
global $table_reversements;global $ligne;global $ligne_new;
global $date_avancement;
global $matricule; 

global $naiss; 
global $total;
global $total_pat;
global $total_fonc;
global $grade;
global $classe;
global $total_cotisations;

$sal = 0;
$grade = $cat;
global $total_verse;
global $total_reliquat; 
$date_avancement = $date_avcmnt;

//---------------------------------------------------------------------------------------

  $ligne_new ='<table class="table2">
  <thead>
    <tr>
      <th class="table2T">Période</th>
      <th class="table2T">Indice</th>
      <th class="table2T">Décompte 18% et 22%</th>
      <th class="table2T">Aurait dû verser</th>
      <th class="table2T">A Versé</th>
      <th class="table2T">Reliquat dû</th>
    </tr>
  </thead>';

  $categorie = $cat; 
  $indice = $ind;
  $date_avancement = $date_avcmnt;
  $matricule = $matricule;
  $naiss = $date_naiss;
  $total = 0;
  $total_pat = 0 ;
  $total_fonct = 0;

  if(($date_debut<("1991-07-01"))&&($date_fin>("1991-07-01"))){
    etat_sommes_dues_periode2($date_debut,"1991-06-30");
    etat_sommes_dues_periode2("1991-07-01",$date_fin); 
    
  }else{
     
    etat_sommes_dues_periode2($date_debut,$date_fin);  
  }

  $etatSD = etat_cotisations($matricule, $date_fin);

  foreach($etatSD as $etat){  

    $date_debut = $etat->dat_deb_cot; $date_fin = $etat->dat_fin_cot;
    $averse = $etat->cot_tot;
    $calcul = 0;
    $reliquat = $calcul - $averse ; //$averse-$calcul;
    
    $ligne_new.="<tr><td class='table2T'>".date_fr($date_debut)." au <br> ".date_fr($date_fin)." <br> soit ".$nbre_jours." jours</td>"; // Periode
  //$ligne.="<td>".date_fr($deb_bar,"fr")." au ". date_fr($fin_bar,"fr")."</td>"; // Barème   
  $ligne_new.="<td align='center' class='table2T'>".$indice."</td>";  
  $ligne_new.="<td align='center' class='table2T'><u>".number_format(ceil($salaire_annuel), 0, ',', '.')." x ".$taux_new." x ".$nbre_jours."</u><br>
  360 x 100 </td>"; 
  $ligne_new.=" <td align='right' class='table2T'> <b>".number_format(ceil($calcul), 0, ',', ' ')."</b></td> ";
  $ligne_new.="<td align='right' class='table2T'><b>".number_format(ceil($averse), 0, ',', ' ')."</b></td>";
  $ligne_new.=" <td align='right' class='table2T'> <b>".number_format(ceil($reliquat), 0, ',', ' ')."</b></td></tr>";
  $total_verse = $averse + $total_verse;
  $total_reliquat = $total_reliquat + $reliquat;
    } 
return $total;
}

function etat_sommes_dues3($cat,$ind,$date_debut,$date_fin,$date_avcmnt,$date_naiss){
//------ Variables 
global $num_bar; global $annee_40_ans;
global $bareme;
global $nbj;
global $salaire;
global $nbm;
global $nba;
global $indice;
global $categorie;
global $table_reversements;global $ligne;global $ligne_new;
global $date_avancement;
global $matricule; 

global $naiss; 
global $total;
global $total_pat;
global $total_fonc;
global $grade;
global $classe;
global $echelon;
global $total_cotisations;

$sal = 0;
$grade = $cat;
global $total_verse;
global $total_reliquat; 
$date_avancement = $date_avcmnt;

//---------------------------------------------------------------------------------------

  $categorie = $cat; 
  $indice = $ind;
  $grade = $grad;
  $classe = $class;
  $echelon = $echl;
  $date_avancement = $date_avcmnt;
  $matricule = $matricule;
  $naiss = $date_naiss;
  $total = 0;
  $total_pat = 0 ;
  $total_fonct = 0;

  if(($date_debut<("1991-07-01"))&&($date_fin>("1991-07-01"))){
    etat_sommes_dues_periode2($date_debut,"1991-06-30");
    etat_sommes_dues_periode2("1991-07-01",$date_fin); 
    
  }else{
     
    etat_sommes_dues_periode2($date_debut,$date_fin);  
  }

  $etatSD = etat_cotisations($matricule, $date_fin);

  foreach($etatSD as $etat){  

    $date_debut = $etat->dat_deb_cot; $date_fin = $etat->dat_fin_cot;
    $averse = $etat->cot_tot;
    $calcul = 0;
    $reliquat = $calcul - $averse ; //$averse-$calcul;
    
  $total_verse = $averse + $total_verse;
  $total_reliquat = $total_reliquat + $reliquat;
    } 
return $total;
}

function etat_sommes_dues_gen($mat, $grad, $class, $echl, $cat,$ind,$date_debut,$date_fin,$date_avcmnt,$date_naiss){
  //------ Variables 
  global $num_bar; global $annee_40_ans;
  global $bareme;
  global $nbj;
  global $salaire;
  global $nbm;
  global $nba;
  global $indice;
  global $categorie;
  global $table_reversements;global $ligne;global $ligne_new;
  global $date_avancement;
  global $matricule; 

  global $naiss; 
  global $total;
  global $total_pat;
  global $total_fonc;
  global $grade;
  global $classe;
  global $echelon;
  global $total_cotisations;

  $sal = 0;
  $grade = $cat;
  global $total_verse;
  global $total_reliquat; 
  $date_avancement = $date_avcmnt;

//---------------------------------------------------------------------------------------

  $categorie = $cat; 
  $indice = $ind;
  $grade = $grad;
  $classe = $class;
  $echelon = $echl;
  $date_avancement = $date_avcmnt;
  $matricule = $mat;
  $naiss = $date_naiss;
  $total = 0;
  $total_pat = 0 ;
  $total_fonct = 0;

  if(($date_debut<("1991-07-01"))&&($date_fin>("1991-07-01"))){
    etat_sommes_dues_periode_gen($date_debut,"1991-06-30");
    etat_sommes_dues_periode_gen("1991-07-01",$date_fin); 
  } else{
    etat_sommes_dues_periode_gen($date_debut,$date_fin);  
  }

  $etatSD = etat_cotisations($matricule, $date_fin);

  foreach($etatSD as $etat){  

    $date_debut = $etat->dat_deb_cot; $date_fin = $etat->dat_fin_cot;
    $averse = $etat->cot_tot;
    $calcul = 0;
    $reliquat = $calcul - $averse ; //$averse-$calcul;
    
  $total_verse = $averse + $total_verse;
  $total_reliquat = $total_reliquat + $reliquat;
    } 
  return $total;
}

function total_cotisation($matricule){
  
global $ligne_cotisation;
global $total_cotisations;

 $ligne_cotisation ='<table class="table table-hover table-light table-striped table-bordered table-sm mt-3"><tr><td colspan="7" align="center"><span class="art-postheadericon"><b>COTISATIONS EFFECTUEES </b></span> </td></tr>
<tr align="center"><td width="30%"><b>PERIODE</b></td><td><b>IND</b></td><td><b>REFERENCES <i>(Titre de paiement)</i></b></td><td><b>RETENUES<i>(Salarié)</i> </b></td><td><b>RETENUES <i>(Patronale)</i></b></td>
<td width="20%"><b>TOTAL</b> </td>
</tr>';
  $data = totalCotisation('%'.$matricule.'%');
  foreach($data as $total){ 
   $ligne_cotisation.='<tr><td> '.$total->dat_deb_cot.' <i> au </i> '.$total->dat_fin_cot.'</td>';
   $ligne_cotisation.='<td>'.$total->cot_ind.'</td><td>'.$total->ref_tip.'</td>';
   $ligne_cotisation.='<td align="right">'.number_format(ceil($total->cot_sal), 0, ',', ' ').'</td><td align="right">'.number_format(ceil($total->cot_pat), 0, ',', ' ').'</td>';
   $ligne_cotisation.='<td align="right"><b>'.number_format(ceil($total->cot_tot), 0, ',', ' ');
   $ligne_cotisation.='</b> </td> </tr>';
   $total_cotisations = $total_cotisations + (int)$total->cot_tot; 
  }
  $ligne_cotisation.='<tr><td colspan="5" align="left"><b>TOTAL</b></td><td align="right"><b>'.number_format($total_cotisations, 0, ',', ' ').'</b></td><tr></table><hr>';
  return $total_cotisations;
}


function total_cotisation2($matricule){
  
global $total_cotisations;

  $data = totalCotisation('%'.$matricule.'%');
  foreach($data as $total){ 
   $total_cotisations = $total_cotisations + (int)$total->cot_tot; 
  }

  return $total_cotisations;
}

function total_esd($cotisations,$reversements){
global $ligne_esd;

 $ligne_esd='<table class="table table-hover table-light table-striped table-bordered table-sm mt-3">
<tr><td align="center" colspan="4"><b>ETAT DE SOMMES DUES </b></td></tr>
<tr><td><b>Période</b></td><td><b>Montant Global Reversement à effectuer</b></td><td><b>Montant Global Cotisé</b></td><td><b>Différence à Payer</b></td></tr>';
 $difference_montant = (int)$reversements - (int)$cotisations; 
 $ligne_esd.='<tr><td >Période</td><td><b>'.number_format($reversements, 0, ',', ' ').'</b></td>';
 $ligne_esd.='<td><b>'.number_format($cotisations, 0, ',', ' ').'</b></td>';
 $ligne_esd.='<td><b>'.number_format($difference_montant, 0, ',', ' ').'</b></td></tr>
</table>';
  
  return $difference_montant;
}

function total_esd2($cotisations,$reversements, $matricule){
  $difference_montant = (int)$reversements - (int)$cotisations;
?> 
<tr>
  <td><?= $matricule; ?>'</td>
  <td><b><?= number_format($reversements, 0, ',', ' '); ?></b></td>
  <td><b><?= number_format($cotisations, 0, ',', ' '); ?></b></td>
  <td><b><?= number_format($difference_montant, 0, ',', ' '); ?></b></td>
</tr>
 <?php
  return $difference_montant;
}

function entete_esd($matricule){

$ligne_entete_esd;
$lang="fr";

$data = enteteEsd($matricule);
  
if (!empty($data)) {

   $nom = $data->nom; 
   $prenom = $data->prenoms;
   $indice = $data->ind_int;
   $indice1 = $data->ind_int;
   $prise_service = $data->dat_pri_ser;
   $organisme = $data->sgl_org;
   $categorie = strtoupper($data->cat_int);
   $categorie1 = strtoupper($data->cat_int);
   $date_effet = $data->dat_eff_det;
   $date_effet1 = returnannee($data->dat_eff_det);
   $date_naiss = $data->date_naissance;
   $date_naiss1 = returnannee($data->date_naissance);
   $date_int = $data->dat_int;
   $date_int1 = returnannee($data->dat_int);
   $age = age($date_naiss);

   if(retraite($categorie,$date_naiss)){
    $etat="Retraité2";
  } else {
    $etat = "En activité";
  }

}

$ligne_entete_esd='<br><h4><u>ETAT DE SOMMES DUES INDIVIDUEL</u></h4>';
$ligne_entete_esd.='<table class="table table-hover table-light table-striped table-bordered table-sm mt-3"><tr><td width="300px"><b>Matricule :</b>'.$matricule.'</td><td width="300px"><b>Noms</b>: '.$nom.' </td><td width="300px"><b>Prénoms</b>:  '.$prenom.' </td></tr><tr><td width="300px"><b>Catégorie :</b>'.$categorie1.'</td><td width="300px"><b>Indice</b>: '.$indice1.' </td><td width="300px"><b>Lieu de détachement :</b> '.$organisme.' </td></tr>
<tr><td width="300px"><b>Date de détachement:</b>'.$date_effet1.' </td><td width="300px"><b>Date de naissance</b>:'.$date_naiss1.'  </td><td width="300px"><b>Date Intégration</b>:  '.$date_int1 .'</td></tr>
<tr><td width="300px"><b>Date Prise de service:</b> '.returnannee($prise_service).'</td><td width="300px"><b>Fin de Détachement</b>: '.$dat_eff_det_fin1.' </td><td width="300px"><b>Age </b>:'.$age.' ans  </td></tr>
</table><br><br>'; 
return $ligne_entete_esd;
} 

function Jour($jourd,$jourf){
  global $m_emp;
  if ($jourf==31){$jourf=30;}
  if ($jourd>$jourf){
    $nbj=30+$jourf-$jourd;
    $m_emp=1;
  } else {
   $nbj = $jourf-$jourd;
   $m_emp = 0;
  }
 return $nbj;
}
//--------------------------Mois------------------------

function Mois($moisd,$moisf){
   global $anne_emp, $m_emp;
   if ($moisf<$moisd){
     $nbm=$moisf+12-$m_emp-$moisd;
     $anne_emp=1;
    }
   else {
     $nbm=$moisf-$moisd-$m_emp;
     $anne_emp=0;
    }
   return $nbm;
  }
//---------------------Année----------------------------------
function Anne($anned,$annef){
   global $anne_emp, $m_emp;
     $nba = $annef-$anned-$anne_emp;
   return $nba;
 }

function  datejourdown($date){
  //-------------------traitement date---------------------
    list($a1,$m1,$j1)=explode("-",$date);
    $jourd=(int)$j1; $moisd=(int)$m1; $anned=(int)$a1;
      $nbj=$jourd-1;
    if ($nbj==0){
      if ($moisd==5||$moisd==7||$moisd==8||$moisd==10||$moisd==12){$moisd=$moisd-1; $jourd=30;
      }else {
        if ($moisd==4||$moisd==6||$moisd==9||$moisd==11){ $moisd=$moisd-1; $jourd=31;;
        }else{
            if ($moisd==1){$moisd=12;$jourd=31;$anned=$anned-1;
            }else{
              if ($moisd==3){if ($anned%4==0){$moisd=2;$jourd=29;
                      }else{$moisd=2;$jourd=28;}
                      }
                }
                }
              }
      }else{
      $jourd=$jourd-1;
      }
// traitement de la date 
  
  $ar=array($anned,$moisd,$jourd);
  $annedeux=implode("-",$ar);
  return $annedeux;
}

// ---------------------------fonction date_deb=date_fin_precedente +1jour-----------------------------------
function datejourupdate($date_fin)
       {
        
  list($a2,$m2,$j2)=explode("-",$date_fin);
  $jour=(int)$j2;
  $mois=(int)$m2;
  $anne=(int)$a2;
         if ($jour==31)
    {
      $jour=01;
    if ($mois==12)
      {
       $mois=01;
       $anne=$anne+1;
      }
    else
      {
       $mois=$mois+1;
      }
           }
  else //jour different de 31
           {
    if ($jour==30)
     {
       if (($mois==4)||($mois==6)||($mois==9)||($mois==11)) 
      
        {
      $jour=1;
      $mois=$mois+1;
        }
     }
    else // jour different de 30 jours
                 {
       if ($jour==28)
        {
      /*if ($mois==2)
        {
        
                    if (($anne%4)==0))
           {
            $jour=$jour+1;
           }
          else
           {
            $jour=1;
            $mois=$mois+1;
           }
         }*/
          }
       else 
        { $jour=$jour+1;}
            }
       }
        $ar=array($anne,$mois,$jour);
  $deb_suiv=implode("-",$ar); 
        return $deb_suiv;
     }

function salaire_base($cat,$ind,$num_bar,$grad){
  global $dbc;global $salaire;
    $data = salaireBase($num_bar, $cat, $ind, $grad);
    foreach($data as $sal){ // Etat de sommes dues d'un bareme
    $salaire = $sal->salaire_base;
  }
  return $salaire;
}

function salaire_base_contractuel($cat,$echl,$num_bar,$grad){
  global $dbc;global $salaire;
    $data = salaireBaseContractuel($num_bar, $echl, $cat, $grad);
    foreach($data as $sal){ // Etat de sommes dues d'un bareme
    $salaire = $sal->salaire_base;
  }
  return $salaire;
}

function salaire_base_magis($ind,$num_bar,$grad){
  global $dbc;global $salaire;
    $data = salaireBaseMagis($ind,$num_bar,$grad);
    foreach($data as $sal){ // Etat de sommes dues d'un bareme
    $salaire = $sal->salaire_base;
  }
  return $salaire;
}


//--------------------------------  AGE AVANCEMENT
function age_avancement(){
  global $naiss; global $date_avancement;
      // Découper la date dans un tableau associatif
  list($annee,$mois,$jour)=explode("-",$naiss); 
  list($annee_avancement,$mois_avancement,$jour_avancement)=explode("-",$date_avancement); 
  // Calculer le nombre d'années entre l'année d'avancement et l'année de naissance
  $annees = (int)$annee_avancement - (int)$annee;
  // Si le mois en cours est inférieur au mois d'anniversaire, enlever un an
  if ((int)$mois_avancement< (int)$mois) {
  $annees--;
  }
  // Pareil si on est dans le bon mois mais que le jour n'est pas encore venu
  if (((int)$mois_avancement==(int)$mois) && ((int)$jour>(int)$jour_avancement)) {
  $annees--;
  }
  return $annees;
}

//---------------------------------Taux-----------------------------------

function taux($date_deb,$date_fin){
  if ($date_fin<("1991-07-01")){
    return 0.18;
  } else {
    if ($date_deb>("1991-07-01")){
      return 0.22;
    }
  }
 }

 function etatNumber(){
  $year = date('Y');
  $text = $year."/....";
  return $text;
 }
/*
 function numberTowords($num){

  $ones = array(
  0 =>"Zéro",
  1 => "Un",
  2 => "Deux",
  3 => "Trois",
  4 => "Quatre",
  5 => "Cinq",
  6 => "Six",
  7 => "Sept",
  8 => "Huit",
  9 => "Neuf",
  10 => "Dix",
  11 => "Onze",
  12 => "Douze",
  13 => "Treize",
  14 => "Quatorze",
  15 => "Quinze",
  16 => "Seize",
  17 => "Dix-Sept",
  18 => "Dix-Huit",
  19 => "Dix-Neuf",
  "014" => "Quatorze"
  );
  $tens = array( 
  0 => "Zéro",
  1 => "Dix",
  2 => "Vingt",
  3 => "Trente", 
  4 => "Quarante", 
  5 => "Cinquante", 
  6 => "Soixante", 
  7 => "Soixante-Dix", 
  8 => "Quatre Vingt", 
  9 => "Quatre Vingt-Dix" 
  ); 
  $hundreds = array( 
  "Cent", 
  "Milles", 
  "Millions", 
  "Milliards", 
  "Trillions", 
  "Quadrillons" 
  ); /*limit t quadrillion */
  /*$num = number_format($num,2,".",","); 
  $num_arr = explode(".",$num); 
  $wholenum = $num_arr[0]; 
  $decnum = $num_arr[1]; 
  $whole_arr = array_reverse(explode(",",$wholenum)); 
  krsort($whole_arr,1); 
  $rettxt = ""; 
  foreach($whole_arr as $key => $i){
    
  while(substr($i,0,1)=="0")
      $i=substr($i,1,5);
  if($i < 20){ */
    /* echo "getting:".$i; */
  /*  $rettxt .= $ones[$i]; 
  } elseif($i < 100){ 
    if(substr($i,0,1)!="0")  $rettxt .= $tens[substr($i,0,1)]; 
    if(substr($i,1,1)!="0") $rettxt .= " ".$ones[substr($i,1,1)]; 
  } else{ 
    if(substr($i,0,1)!="0") $rettxt .= $ones[substr($i,0,1)]." ".$hundreds[0]; 
    if(substr($i,1,1)!="0")$rettxt .= " ".$tens[substr($i,1,1)]; 
    if(substr($i,2,1)!="0")$rettxt .= " ".$ones[substr($i,2,1)]; 
  } 
    if($key > 0){ 
      $rettxt .= " ".$hundreds[$key]." "; 
    }
  } 
  if($decnum > 0){
    $rettxt .= "-";
    if($decnum < 20){
      $rettxt .= $ones[$decnum];
    } elseif($decnum < 100){
      $rettxt .= $tens[substr($decnum,0,1)];
      $rettxt .= " ".$ones[substr($decnum,1,1)];
    }
  }
  return $rettxt;
}

function chifre_en_lettre($montant){
    $dev1 = 'FCFA';
    $valeur_entiere=intval($montant);
    $valeur_decimal=intval(round($montant-intval($montant), 2)*100);
    $dix_c=intval($valeur_decimal%100/10);
    $cent_c=intval($valeur_decimal%1000/100);
    $unite[1]=$valeur_entiere%10;
    $dix[1]=intval($valeur_entiere%100/10);
    $cent[1]=intval($valeur_entiere%1000/100);
    $unite[2]=intval($valeur_entiere%10000/1000);
    $dix[2]=intval($valeur_entiere%100000/10000);
    $cent[2]=intval($valeur_entiere%1000000/100000);
    $unite[3]=intval($valeur_entiere%10000000/1000000);
    $dix[3]=intval($valeur_entiere%100000000/10000000);
    $cent[3]=intval($valeur_entiere%1000000000/100000000);
    $chif=array('', 'un', 'deux', 'trois', 'quatre', 'cinq', 'six', 'sept', 'huit', 'neuf', 'dix', 'onze', 'douze', 'treize', 'quatorze', 'quinze', 'seize', 'dix sept', 'dix huit', 'dix neuf');
        $secon_c='';
        $trio_c='';
    for($i=1; $i<=3; $i++){
        $prim[$i]='';
        $secon[$i]='';
        $trio[$i]='';
        if($dix[$i]==0){
            $secon[$i]='';
            $prim[$i]=$chif[$unite[$i]];
        }
        else if($dix[$i]==1){
            $secon[$i]='';
            $prim[$i]=$chif[($unite[$i]+10)];
        }
        else if($dix[$i]==2){
            if($unite[$i]==1){
            $secon[$i]='vingt et';
            $prim[$i]=$chif[$unite[$i]];
            }
            else {
            $secon[$i]='vingt';
            $prim[$i]=$chif[$unite[$i]];
            }
        }
        else if($dix[$i]==3){
            if($unite[$i]==1){
            $secon[$i]='trente et';
            $prim[$i]=$chif[$unite[$i]];
            }
            else {
            $secon[$i]='trente';
            $prim[$i]=$chif[$unite[$i]];
            }
        }
        else if($dix[$i]==4){
            if($unite[$i]==1){
            $secon[$i]='quarante et';
            $prim[$i]=$chif[$unite[$i]];
            }
            else {
            $secon[$i]='quarante';
            $prim[$i]=$chif[$unite[$i]];
            }
        }
        else if($dix[$i]==5){
            if($unite[$i]==1){
            $secon[$i]='cinquante et';
            $prim[$i]=$chif[$unite[$i]];
            }
            else {
            $secon[$i]='cinquante';
            $prim[$i]=$chif[$unite[$i]];
            }
        }
        else if($dix[$i]==6){
            if($unite[$i]==1){
            $secon[$i]='soixante et';
            $prim[$i]=$chif[$unite[$i]];
            }
            else {
            $secon[$i]='soixante';
            $prim[$i]=$chif[$unite[$i]];
            }
        }
        else if($dix[$i]==7){
            if($unite[$i]==1){
            $secon[$i]='soixante et';
            $prim[$i]=$chif[$unite[$i]+10];
            }
            else {
            $secon[$i]='soixante';
            $prim[$i]=$chif[$unite[$i]+10];
            }
        }
        else if($dix[$i]==8){
            if($unite[$i]==1){
            $secon[$i]='quatre-vingts et';
            $prim[$i]=$chif[$unite[$i]];
            }
            else {
            $secon[$i]='quatre-vingt';
            $prim[$i]=$chif[$unite[$i]];
            }
        }
        else if($dix[$i]==9){
            if($unite[$i]==1){
            $secon[$i]='quatre-vingts et';
            $prim[$i]=$chif[$unite[$i]+10];
            }
            else {
            $secon[$i]='quatre-vingts';
            $prim[$i]=$chif[$unite[$i]+10];
            }
        }
        if($cent[$i]==1) $trio[$i]='cent';
        else if($cent[$i]!=0 || $cent[$i]!='') $trio[$i]=$chif[$cent[$i]] .' cents';
    }
     
     
$chif2=array('', 'dix', 'vingt', 'trente', 'quarante', 'cinquante', 'soixante', 'soixante-dix', 'quatre-vingts', 'quatre-vingts dix');
    $secon_c=$chif2[$dix_c];
    if($cent_c==1) $trio_c='cent';
    else if($cent_c!=0 || $cent_c!='') $trio_c=$chif[$cent_c] .' cents';
     
    if(($cent[3]==0 || $cent[3]=='') && ($dix[3]==0 || $dix[3]=='') && ($unite[3]==1))
        echo $trio[3]. '  ' .$secon[3]. ' ' . $prim[3]. ' million ';
    else if(($cent[3]!=0 && $cent[3]!='') || ($dix[3]!=0 && $dix[3]!='') || ($unite[3]!=0 && $unite[3]!=''))
        echo $trio[3]. ' ' .$secon[3]. ' ' . $prim[3]. ' millions ';
    else
        echo $trio[3]. ' ' .$secon[3]. ' ' . $prim[3];
     
    if(($cent[2]==0 || $cent[2]=='') && ($dix[2]==0 || $dix[2]=='') && ($unite[2]==1))
        echo ' mille ';
    else if(($cent[2]!=0 && $cent[2]!='') || ($dix[2]!=0 && $dix[2]!='') || ($unite[2]!=0 && $unite[2]!=''))
        echo $trio[2]. ' ' .$secon[2]. ' ' . $prim[2]. ' milles ';
    else
        echo $trio[2]. ' ' .$secon[2]. ' ' . $prim[2];
     
    echo $trio[1]. ' ' .$secon[1]. ' ' . $prim[1];
     
    echo ' '. $dev1 .' ' ;
}*/