<?php

     $document->addStyleSheet(JURI::base() . 'components/com_angifode/assets/css2/bootstrap.min.css');
	$document->addStyleSheet(JURI::base() . 'components/com_angifode/assets/css2/dataTables.bootstrap4.min.css');

?>
<?php

//#################################### PROCEDURES ET FONCTIONS
//--------------------------------  FIN DETACHEMENT, renvoie la date de fin de détachement
function date_fin_detachement($matricule,$sgl_org,$categorie,$naiss,$indice)
    {
//-- Date de fin de détachement,retraite ou activité
//require 'connect2.php'; 

//return;
$req2="SELECT `dat_det_fin` FROM `psalm23_angifode_angifode_agent`";
$req2.="WHERE `matricule`='".$matricule."'  ";
$execution2=mysqli_query($dbc,$req2) or die("bad query: $req2");
$date_fin=0;
if ($row2 = mysqli_fetch_array($execution2,MYSQLI_NUM)){ // recupéreration  du resultat
	$date_fin=$row2[0];
  }else{
	if(retraite($categorie,$naiss)){ 
	  $date_fin=retraite($categorie,$naiss);
	 }else{
	  $date_fin=date("Y-m-d"); 
	}
}
return $date_fin;
}

//--------------------------------  AGE AVANCEMENT
function age_avancement()
    {
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
//--------------------------------  AGES
function age($naiss)
    {
    // Découper la date dans un tableau associatif
list($annee,$mois,$jour)=explode("-",$naiss); 
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
if ($mois == $today['mois'] && $jour> $today['jour']) {
$annees--;
}
return $annees;
    }
//--------------------------------  Année des quarante ans
function annee_quarante_ans($naiss)
    {
    // Découper la date dans un tableau associatif
list($annee,$mois,$jour)=explode("-",$naiss); 
$annee=(int)$annee+40;
$annee1=$annee."-".$mois."-".$jour;
return $annee1;
    }
//--------------------------------  AGES
function annee_retraite($naiss,$annee)
    {
    // Découper la date dans un tableau associatif
list($annee,$mois,$jour)=explode("-",$naiss); 

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
if ($mois == $today['mois'] && $jour> $today['jour']) {
$annees--;
}
return $annees;
    }
//------------------------------------------------------------------------

function retraite($categorie,$naiss)
 {
   if (($categorie=="A1") || ($categorie=="A2"))
    {
      if (age($naiss)<55)
       {
        return false; //pas encore à la retraite
       }
      else
       {
        list($annee,$mois,$jour)=explode("-",$naiss); 
	$annee_retraite=(int)$annee+55;$annee_retraite=$annee_retraite."-".$mois."-".$jour;
	return $annee_retraite;// déjà à la retriate
       }
    }
if (($categorie=="B1") || ($categorie=="B2"))
    {
      if (age($naiss)<55)
       {
        return false;//pas encore à la retraite
       }
      else
       {
        list($annee,$mois,$jour)=explode("-",$naiss); 
	$annee_retraite=(int)$annee+55; $annee_retraite=$annee_retraite."-".$mois."-".$jour;
	return $annee_retraite;// déjà à la retriate
       }
    }
if (($categorie=="C") || ($categorie=="D"))
    {
      if (age($naiss)<50)
       {
        return false;//pas encore à la retraite
       }
      else
       {
        list($annee,$mois,$jour)=explode("-",$naiss); 
	$annee_retraite=(int)$annee+50; $annee_retraite=$annee_retraite."-".$mois."-".$jour;
	return $annee_retraite;// déjà à la retriate
       }
    }
 }
//##########################################################################

//##########################################################################

//------------- Numero de Baremes
function numero_bareme($date_deb,$date_fin,$indice){
  
//$host='localhost';
//$user='root';
//$pwd='minfi';
//$dbc=mysql_connect($host,$user,$pwd) or die ("erreur connect");
//$bd=mysql_select_db("angifode") or die ("erreurpp");
//$dbc = mysqli_connect('localhost','ddppangifode','AngiFode@ciddpp18','angifode')or die("bad connecxion".mysqli_connect_error());
 
	
	$req2="SELECT  DISTINCT(psalm23_antilope_baremes.num_bar ) , bru_sol,dat_deb,dat_fin FROM psalm23_antilope_baremes,psalm23_antilope_baremes_type
	WHERE ((psalm23_antilope_baremes_type.dat_deb<='$date_fin') AND (psalm23_antilope_baremes_type.dat_fin>='$date_deb')
	 AND (psalm23_antilope_baremes_type.num_bar=psalm23_antilope_baremes.num_bar) AND (ind_sol='$indice')) ORDER BY dat_deb";
   $execution2=mysqli_query($dbc,$req2) ;
	$calcul=0; 

   while ($row2 = mysqli_fetch_array($execution2,MYSQLI_NUM)){ // recupéreration  du resultat
	  //echo"<br>".$bareme=$row2[0]; echo"<br>".$Salaire=$row2[1]; echo"<br>".$deb_bar=$row2[2];echo"<br>".$fin_bar=$row2[3];
	  while ($date_deb<=$date_fin)
	   {
	    if ($date_fin<=$row2[3]) // fin du bareme en cours
  	     {
	      $calcul=$calcul+versement($row2[1],$date_deb,$date_fin);
	      //echo"<br>------1<br>".$calcul ;
	       $date_deb=datejourupdate($date_fin);
	     }
	    else
	     { // dATE Fin supérieur à la date de de fin du  bareme 
	     	 $calcul=$calcul+versement($row2[1],$date_deb,$row2[3]);
	     	 //echo"<br>------1<br>".$calcul ;
	     	 $date_deb=datejourupdate($row2[3]);
	     }
	   }
   }
   mysqli_free_result($execution2); 
return $calcul;
}


// ---------------------------fonction date_deb=date_fin - 1 jour -----------------------------------
function  datejourdown($date)
 {
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
		    {	$jour=$jour+1;}
	          }
	     }
        $ar=array($anne,$mois,$jour);
	$deb_suiv=implode("-",$ar); 
        return $deb_suiv;
     }
//----------------------------traitement de la date date_fin on ajoute deux ans---------------------------
      function dateupdate($date_up)
       {
	list($a2,$m2,$j2)=explode("-",$date_up);
	$jour=$j2;
	$mois=$m2;
	$anne=(int)$a2;
	$anne=$anne+2;
	$ar=array($anne,$mois,$jour);
	$annedeux=implode("-",$ar);
        return $annedeux;
       }	  
	    
//---------------------------jour-----------------

		function Jour($jourd,$jourf)
		 {
		   global $m_emp;
		   if ($jourf==31){$jourf=30;}
		   if ($jourd>$jourf)
		    {
		     $nbj=30+$jourf-$jourd;
		     $m_emp=1;
		    }
		   else
		    {
		     $nbj=$jourf-$jourd;
		     $m_emp=0;
		    }
		   return $nbj;
		  }
//--------------------------Mois------------------------

		function Mois($moisd,$moisf)
		 {
		   global $anne_emp, $m_emp;
		   if ($moisf<$moisd)
		    {
		     $nbm=$moisf+12-$m_emp-$moisd;
		     $anne_emp=1;
		    }
		   else
		    {
		     $nbm=$moisf-$moisd-$m_emp;
		     $anne_emp=0;
		    }
		   return $nbm;
		  }
//---------------------Année----------------------------------

		function Anne($anned,$annef)
		 {
		   global $anne_emp, $m_emp;
		   
		    
		     $nba=$annef-$anned-$anne_emp;
		     
		   
		   return $nba;
		 }
//--------------fonction calcul de jour-------------------------------------
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

//---------------------------------Taux-----------------------------------

	function taux($date_deb,$date_fin)
	 {
	   if ($date_fin<("1991-07-01"))
	    {
	     return 0.18;
	    }
	   else
	    {
	     if ($date_deb>("1991-07-01"))
	      {
	       return 0.22;
	      }
	    }
         }
//--------------------------------------------------------------------------------
function indice_suivant($ind,$cat,$a)
{
global $table_reversements;global $naiss;global $matricule;global $categorie;global $indice;global $num_bar;global $dbc;  global $annee_40_ans; global $echelon; global $grade; global $classe;
$cat=$categorie;$ind=$indice; // echo'/'.age_avancement().'-'.$ind;
  if(($cat=="B1")&&(age_avancement()>40)){ $cat="B2"; }
  //if(($cat=="A1")&&(age_avancement()>40)){ $cat="A2"; }
  if(($cat=="A1")&&($ind>740)){ 
	if(age_avancement()>40){
		$cat="A2"; }else{
		if($annee_40_ans!="0000-00-00"){echo"****".$annee_40_ans=annee_quarante_ans($naiss);}
	}
  }
  //------------
  
  $categorie=$cat;$grade=$cat;
  $req2="SELECT MIN(`ind_sol`)  FROM `psalm23_antilope_baremes`
	WHERE (`cat_sol`='$cat') AND (`ind_sol`>'$ind') ";
  	$execution2=mysqli_query($dbc,$req2); 
  if ($row2 = mysqli_fetch_array($execution2,MYSQLI_NUM)){
		 $ind=$row2[0] ;	
	}
	 mysqli_free_result($execution2); 
  if($ind>$indice){ $indice=$ind;}
	 return $indice;
}
//--------------------------------------------------------------------------------
//-----Retourne la date d'avancement la plus proche de début et l'indice se calculant au moment d'effectuer l'etat des sommes dues --------
function date_avancement($annee_integration,$annee_debut)
{
	$annee=$annee_integration;  
	while($annee<$annee_debut){
		 $annee=dateupdate($annee);		
	}
	return $annee;
}
//--------------------------------------------------------------------------------

// ----------------------Retourne le salaire de base en foncton de l'indice et de la categorie ---------------------------------------
function salaire_base($cat,$ind,$num_bar)
{
	global $dbc;global $salaire;
	$req2="SELECT `bru_sol` FROM `psalm23_antilope_baremes` WHERE (`num_bar`='$num_bar') AND  (`cat_sol`='$cat') AND (`ind_sol`=($ind))";
  	$execution2=mysqli_query($dbc,$req2);
   	while ($row2 = mysqli_fetch_array($execution2,MYSQLI_NUM)){ // Etat de sommes dues d'un bareme
		$salaire=$row2[0];
	}
	return $salaire;
 
}
//--------------------------------------------------------------------------------
 
function etat_sommes_dues_periode_bareme_avancement($date_debut,$date_fin)
{
global $dbc;global $ligne;global $ligne_new;global $categorie;global $indice;global $fin_bar; global $deb_bar;global $salaire;global $num_bar;
global $echelon; global $grade; global $classe;global $matricule;global $total;global $total_pat;global $total_fonc;global $total_verse;global $total_reliquat;
//-------------------- Récupération du l'échelon et de la classe

  $req2="SELECT `ech_sol` FROM `psalm23_antilope_baremes` WHERE `ind_sol`='".$indice."' AND `cat_sol`='".$grade."' AND `num_bar`='BF20'";
  	//$execution2=$dbc->query($req2); 
	$execution2=mysqli_query($dbc,$req2);
	 //return;
   	//while ($row2 = $execution2->fetch_array(MYSQLI_NUM))
		
	while ($row2 = mysqli_fetch_array($execution2,MYSQLI_NUM)){ // Etat de sommes dues d'un bareme
		 $classe=$row2[0][0]; $echelon= substr(($echelon11=$row2[0]),2,3); 
		 //echo $echelon."-";
		 //$echelon=$row2[0][2][3];  $echelon=substr(($echelon=$row2[0]),2,3);
	}
	//echo "Classe".$classe " and echel:".$echelon; 
// Calcul du salaire, et déduction de l'avancement et de l'indice suivant

	$salaire=salaire_base($categorie,$indice,$num_bar);
	$nbre_jours=Fdate($date_debut,$date_fin);	
	if ($date_fin<("1991-07-01")){$taux="18%";$taux1=0.18;$taux_fonc="06%";$taux_fonc1=0.06;}else{$taux="22%";$taux1=0.22;$taux_fonc="10%";$taux_fonc1=0.10;}	
	$taux_pat=0.12; // Taux patronal
	$calcul=$salaire*$taux1*12*$nbre_jours/360; $salaire_annuel=$salaire*12;$taux_new=$taux1*100;
	$calcul_pat=$salaire*$taux_pat*12*$nbre_jours/360;
	$calcul_fonc=$salaire*$taux_fonc1*12*$nbre_jours/360;
	$total=$total+$calcul;$total_pat=$total_pat+$calcul_pat;$total_fonc=$total_fonc+$calcul_fonc;
	//$ligne.= '<div class="table-responsive"> <table  class="table table-hover table-bordered mt-4">';
	$ligne.="<tr><td>".date_fr($date_debut,"fr")." au <br>". date_fr($date_fin,"fr")."</td>"; // Periode
	$ligne.="<td>".date_fr($deb_bar,"fr")." au ". date_fr($fin_bar,"fr")."</td>"; // Barème		
	$ligne.="<td align='center'>CAT ".$grade." | ".$classe." | ".$echelon."</td>"."<td align='center'>".$indice."</td>"; 	
	$ligne.="<td align='center'>".$nbre_jours."</td>"; 
	$ligne.="<td align='center'>".number_format(ceil($salaire), 0, ',', ' ')."</td>";
	$ligne.="<td align='center'>".$taux_fonc."</td>";
	$ligne.=" <td align='right'> <b>".number_format(ceil($calcul_fonc), 0, ',', ' ')."</b></td>";
	$ligne.="<td align='center'>12%</td>";
	$ligne.=" <td align='right'> <b>".number_format(ceil($calcul_pat), 0, ',', ' ')."</b></td>";
	if($verification_taux){$ligne.="<td align='center'>20%</td>";}else{$ligne.="<td align='center'>".$taux."</td>";}
	$ligne.=" <td align='right'> <b>".number_format(ceil($calcul), 0, ',', ' ')."</b></td> </tr>";
	//$ligne.= '</div> </table>';
	//-------------------  Ligne New
	// Montant cotisé pour la période
	  $req3_1="SELECT SUM( `cot_tot` ) FROM `psalm23_angifode_angifode_cotisations` WHERE (`matricule` = '".$matricule."') AND ( `dat_deb_cot` >= '".$date_debut."') AND ( `dat_deb_cot` < '".$date_fin."')";
  	$execution3_1=mysqli_query($dbc,$req3_1); while ($row3_1=mysqli_fetch_array($execution3_1,MYSQLI_NUM)){  	$sum3_1=$row3_1[0]; } //echo $sum3_1;
	//echo $req3_2="SELECT SUM( `cot_tot` ) FROM `psalm23_angifode_angifode_cotisations` WHERE (`matricule` = '".$matricule."') AND ( `dat_fin_cot` <='".$date_debut."')";
  	//$execution3_2=mysqli_query($dbc,$req3_2); while ($row3_2=mysqli_fetch_array($execution3_2,MYSQLI_NUM)){ 	 $sum3_2=$row3_2[0]; }
   // $averse=$sum3_1 - $sum3_2;$reliquat=$calcul - $averse;$total_verse=$averse+$total_verse;$total_reliquat=$total_reliquat+$reliquat;
	$averse=$sum3_1; $reliquat=$calcul - $averse;$total_verse=$averse+$total_verse;$total_reliquat=$total_reliquat+$reliquat;
	//---
	$ligne_new.="<tr><td>".date_fr($date_debut,"fr")." au <br> ". date_fr($date_fin,"fr")." <br> soit ".$nbre_jours." jours</td>"; // Periode
	//$ligne.="<td>".date_fr($deb_bar,"fr")." au ". date_fr($fin_bar,"fr")."</td>"; // Barème		
	$ligne_new.="<td align='center'>".$indice."</td>"; 	
	$ligne_new.="<td align='center'><u>".number_format(ceil($salaire_annuel), 0, ',', '.')." x ".$taux_new." x ".$nbre_jours."</u><br>
	360 x 100 </td>"; 
	$ligne_new.=" <td align='right'> <b>".number_format(ceil($calcul), 0, ',', ' ')."</b></td> ";
	$ligne_new.="<td align='right'><b>".number_format(ceil($averse), 0, ',', ' ')."</b></td>";
	$ligne_new.=" <td align='right'> <b>".number_format(ceil($reliquat), 0, ',', ' ')."</b></td></tr>";
}
//--------------------------------------------------------------------------------


function etat_sommes_dues_periode_bareme($date_debut,$date_fin)
{
global $table_reversements;global $date_avancement;global $matricule;global $categorie;global $indice;global $num_bar;global $annee_40_ans; global $categorie;
//------ Etat de sommes dues période, retourne l'indice évolué
	// echo " ----- Date de début période=".$date_debut; echo " Date de fin de période=".$date_fin;echo " <br> ";
 	// echo " ----- Categorie=".$categorie; echo " Indice=".$indice;echo " date avancement=".$date_avancement;echo " Matricule=".$matricule;echo 		" <br> ";
	//echo "--------------".$annee_40_ans;
	//return;
	while($date_avancement<$date_fin){
	// listing de tous les avancements
	 //echo "<br>...début =".$date_debut." Fin =".datejourdown($date_avancement)." Avancement";
	//$salaire=salaire_base($categorie,$indice,$num_bar);
	if(($date_debut<=$annee_40_ans)&&($annee_40_ans<=$date_avancement)){
		echo"////////".$date_fin2=$annee_40_ans;
		etat_sommes_dues_periode_bareme_avancement($date_debut,$annee_40_ans);
		$date_debut=datejourupdate($annee_40_ans);		
		$date_avancement=dateupdate($date_fin2);
		$annee_40_ans="0000-00-00";	
		if($categorie=="A1"){$categorie="A2";} if($categorie=="B1"){$categorie="B2";}
		$indice=indice_suivant();
	 }
	 
	etat_sommes_dues_periode_bareme_avancement($date_debut,datejourdown($date_avancement));	
	$date_debut=$date_avancement;
	$date_avancement=dateupdate($date_avancement);
	indice_suivant($ind,$cat,$a);//$indice=indice_suivant();
	}
	//echo "<br>...début =".$date_debut." Fin $date_fin periode ou de bareme et Numero Bareme=$num_bar";
	etat_sommes_dues_periode_bareme_avancement($date_debut,$date_fin);
			
return;	
}
//--------------------------------------------------------------------------------


function etat_sommes_dues_periode($date_debut,$date_fin)
{
	global $matricule; 
global $categorie;global $indice;global $table_reversements;global $date_avancement;global $matricule;global $dbc;
global $fin_bar; global $deb_bar;global $indice;global $salaire;global $num_bar;
//------ Etat de sommes dues période, retourne l'indice évolué
//echo " Categorie=".$categorie; echo " Indicez=".$indice;echo " date avancement=".$date_avancement;echo " Matricule=".$matricule;

while($date_debut<$date_fin){
	// recherche liste de baremes
	  $req2="SELECT num_bar  , dat_deb,dat_fin FROM psalm23_antilope_baremes_type WHERE (dat_deb<='$date_fin') AND 		(dat_fin>='$date_debut') ORDER BY dat_deb";
   	$execution2=mysqli_query($dbc,$req2);
	//$execution2=$dbc->query($req2);  
	$calcul=0; $boucle=0;

   	while ($row2 = mysqli_fetch_array($execution2,MYSQLI_NUM)){ // Etat de sommes dues d'un bareme
		  $num_bar=$row2[0];$fin_bar=$row2[2]; $deb_bar=$row2[1]; //$date_fin=$fin_bar;;
		// echo "<br>+Numero bareme=".$num_bar."  / Date de début bareme=".$deb_bar."  / Date de fin bareme=".$fin_bar." / Date de Fin =".$date_fin."//<br>";		
		if($date_fin<$fin_bar){
		etat_sommes_dues_periode_bareme($date_debut,$date_fin);
		}else{
		etat_sommes_dues_periode_bareme($date_debut,$fin_bar);
		}		
	 $date_debut=datejourupdate($fin_bar);	
	}
	
}
return;
}
//--------------------------------------------------------------------------------


function etat_sommes_dues($cat,$ind,$date_debut,$date_fin,$date_avcmnt,$date_naiss)
{
//------ Variables 
global $dbc;global $num_bar; global $annee_40_ans;
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

global $naiss; global $total;global $total_pat;global $total_fonc; global $grade; global $classe;global $total_cotisations;
$sal=0;$grade=$cat;global $total_verse;global $total_reliquat; 
$date_avancement=$date_avcmnt;
//------------------Connexion à la base de données---------------------------------------
require 'connect2.php'; 
//echo "<br>matricule = $matricule / date Debut=$date_debut / Date Fin=$date_fin" ;
//echo "catt=$cat ,Index=$ind, start=$date_debut, end= $date_fin,increment=$date_avcmnt,Dob=$date_naiss</br>";
//---------------------------------------------------------------------------------------
$ligne='<div class="table-responsive"> <table  class="table table-hover table-bordered mt-4">
<tr><td align="center" colspan="12"><span class="art-postheadericon"><b>REVERSEMENTS A EFFECTUER </b></span></td></tr>
<tr >
<td  ><b>Période</b></td><td  ><b>Barème</b></td><td  ><b>Avancements</b></td><td  ><b>Indice </b></td><td  ><b> Jours</b></td> <td><b>Salaire de Base</b></td><td  ><b>Taux Salarié</b></td><td   <b>Rev. Salarié</b></td><td  ><b>Taux Pat </b></td><td  > <b>Rev. Patronal</b></td><td><b>Taux </b></td><td > <b>Reversements</b></td> </tr>';

$ligne_new='<div class="table-responsive"> <table  class="table table-hover table-bordered mt-4">
<td width="20px"  ><b>Période</b></td><td width="20px"><b>Indice</b></td><td width="40px"><b>Décompte 18% et 22%</b></td><td width="30px"><b>Aurait dû verser </b></td><td width="40px"><b> A Versé</b></td> <td width="70px"><b>Reliquat dû</b></td> </tr>';

$categorie=$cat; $indice=$ind;$date_avancement=$date_avcmnt;$matricule=$matricule;$naiss=$date_naiss;
$total=0;$total_pat=0 ;$total_fonct=0;
	if(($date_debut<("1991-07-01"))&&($date_fin>("1991-07-01"))){
		etat_sommes_dues_periode($date_debut,"1991-06-30");
		etat_sommes_dues_periode("1991-07-01",$date_fin);	
		
	}else{
		 
		etat_sommes_dues_periode($date_debut,$date_fin);	
	}
$ligne.="<tr><td align='right' colspan='7'><b>TOTAL SALARIE</b></td> <td align='right'> <b>".number_format(ceil($total_fonc), 0, ',', ' ')."</b></td>";	
$ligne.="<td align='right' ><b>TOTAL PATRONAL</b></td> <td align='right'> <b>".number_format(ceil($total_pat), 0, ',', ' ')."</b></td>";		

  $ligne.="<td align='right' ><b>TOTAL </b></td> <td align='right'> <b>".number_format(ceil($total), 0, ',', ' ')."</b></td> </tr></div></table>";	
 //return;

//---- Verification des cotisations effectuées hors période de détachement
     $req4="SELECT `dat_deb_cot`, `dat_fin_cot`, `cot_tot`,`cot_ind` FROM `psalm23_angifode_angifode_cotisations` WHERE (`matricule` = '".$matricule."') AND ( `dat_fin_cot` > '".$date_fin."')";
	$execution4=mysqli_query($req4); while ($row4=mysqli_fetch_array($execution4,MYSQLI_NUM)){ 	
  	$date_debut=$row4[0];$date_fin=$row4[1]; $averse=$row4[2];$calcul=0;$reliquat=$calcul - $averse ; //$averse-$calcul;
  	$ligne_new.="<tr><td>".date_fr($date_debut,"fr")." au <br> ". date_fr($date_fin,"fr")." <br> Fin de Détachement </td>";
	$ligne_new.="<td align='center'>".$indice."</td>";   
	$ligne_new.="<td align='center'><u>Regularisation</u><br> </td><td align='right'> <b>".$calcul."</b></td> ";
	$ligne_new.="<td align='right'><b>".number_format(ceil($averse), 0, ',', ' ')."</b></td>";	
	$ligne_new.=" <td align='right'> <b>".number_format(ceil($reliquat), 0, ',', ' ')."</b></td></tr></div></table>";
	$total_verse=$averse+$total_verse;$total_reliquat=$total_reliquat+$reliquat;
  	} 
  		
	
	//--------------------------------


return $total;
} // fIN DE LA FONCTION etat_sommes_dues

//--------------------------------  AGE AVANCEMENT
function total_cotisation($matricule){
global $ligne_cotisation;global $total_cotisations;
 require 'connect2.php'; 
$lang="fr";

 $ligne_cotisation='<br><br><br><div class="table-responsive"> <table  class="table table-hover table-bordered mt-4">
 <tr><td colspan="7" align="center"><span class="art-postheadericon"><b>COTISATIONS EFFECTUEES </b></span> </td></tr>
<tr align="center"><td width="30%"><b>PERIODE</b></td><td><b>IND</b></td><td><b>REFERENCES <i>(Titre de paiement)</i></b></td><td><b>RETENUES<i>(Salarié)</i> </b></td><td><b>RETENUES <i>(Patronale)</i></b></td>
<td width="20%"><b>TOTAL</b> </td>
</tr>';
  $req2="SELECT  `matricule`, `cot_sal`, `cot_pat`, `cot_tot`, `cot_ind`, `cot_sib`,`dat_deb_cot`, `dat_fin_cot`, `ref_tip`  ";
  $req2.=" FROM `psalm23_angifode_angifode_cotisations` ";
  $req2.=" WHERE (matricule LIKE '%$matricule%') ORDER BY dat_deb_cot ";
  //$execution2=$dbc->query($req2); 
    $execution2=mysqli_query($dbc,$req2);
  while ($row2 = mysqli_fetch_array($execution2,MYSQLI_NUM)){ // recupéreration  du resultat
   $ligne_cotisation.='<tr><td> '.returnannee($row2[6],$lang).' <i> au </i> '.returnannee($row2[7],$lang).'</td>';
   $ligne_cotisation.='<td>'.$row2[4].'</td><td>'.$row2[8].'</td>';
   $ligne_cotisation.='<td align="right">'.number_format(ceil($row2[1]), 0, ',', ' ').'</td><td align="right">'.number_format(ceil($row2[2]), 0, ',', ' ').'</td>';
   $ligne_cotisation.='<td align="right"><b>'.number_format(ceil($row2[3]), 0, ',', ' ');
   $ligne_cotisation.='</b> </td> </tr>';
   $total_cotisations = $total_cotisations + (int)$row2[3]; 
  }
  $ligne_cotisation.='<tr><td colspan="5" align="right"><b>TOTAL</b></td><td align="right"><b>'.number_format($total_cotisations, 0, ',', ' ').'</b></td><tr></div></table><br><br><br>';
  return $total_cotisations;
}
//-------------------------------------------------------
function total_esd($cotisations,$reversements){
global $ligne_esd;
$lang="fr";

 $ligne_esd='<div class="table-responsive"> <table  class="table table-hover table-bordered mt-4">
<tr><td align="center" colspan="4"><span class="art-postheadericon"><font color="red"><b>ETAT DE SOMMES DUES </b></font></span></td></tr>
<tr><td><b>Période</b></td><td><b>Montant Global Reversement à effectuer</b></td><td><b>Montant Global Cotisé</b></td><td><b>Différence à Payer</b></td></tr>';
 $difference_montant=(int)$reversements-(int)$cotisations; 
 $ligne_esd.='<tr><td >Période</td><td align="right"><b>'.number_format($reversements, 0, ',', ' ').'</b></td>';
 $ligne_esd.='<td align="right"><b>'.number_format($cotisations, 0, ',', ' ').'</b></td>';
 $ligne_esd.='<td align="right"><b><font color="red">'.number_format($difference_montant, 0, ',', ' ').'</font></b></td></tr>
</div></table>';
  
  return $difference_montant;
}	
	
//-----------------------------------------------------------------------
/*function entete_esd($matricule){

$ligne_entete_esd;
$lang="fr";

 $requete="SELECT psalm23_angifode_angifode_agent.matricule matricule, `nom` , `prenoms`,sgl_org, dat_pri_ser, dat_eff_det,date_naissance,gra_int,ech_int,ind_int, cat_int, cor_int,dat_int FROM `psalm23_angifode_angifode_agent`";
$requete.=" WHERE (psalm23_angifode_angifode_agent.matricule=psalm23_antilope_agent.matricule) AND (psalm23_angifode_angifode_agent.matricule='".$matricule."')";
$result = $dbc->query($requete);   
if ( $row = $result->fetch_object()) {
   $nom=$row->nom; $prenom=$row->prenoms;$indice=$row->ind_int;$indice1=$row->ind_int; $prise_service=$row->dat_pri_ser;$organisme=$row->sgl_org;$categorie=strtoupper($row->cat_int);$categorie1=strtoupper($row->cat_int);$date_effet=$row->dat_eff_det;$date_effet1=returnannee($row->dat_eff_det);$date_naiss=$row->date_naissance;$date_naiss1=returnannee($row->date_naissance);$date_int=$row->dat_int;$date_int1=returnannee($row->dat_int);$age=age($date_naiss);
   if(retraite($categorie,$date_naiss)){ $etat="Retraité2";}else{$etat="En activité";} 
}
mysqli_free_result($result);
$ligne_entete_esd='<br><br><h4><u>ETAT DE SOMMES DUES INDIVIDUEL</u></h4>';
$ligne_entete_esd.='<table width="100%"><tr><td width="300px"><b>Matricule :</b>'.$matricule.'</td><td width="300px"><b>Noms</b>: '.$nom.' </td><td width="300px"><b>Prénoms</b>:  '.$prenom.' </td></tr><tr><td width="300px"><b>Catégorie :</b>'.$categorie1.'</td><td width="300px"><b>Indice</b>: '.$indice1.' </td><td width="300px"><b>Lieu de détachement :</b> '.$organisme.' </td></tr>
<tr><td width="300px"><b>Date de détachement:</b>'.$date_effet1.' </td><td width="300px"><b>Date de naissance</b>:'.$date_naiss1.'  </td><td width="300px"><b>Date Intégration</b>:  '.$date_int1 .'</td></tr>
<tr><td width="300px"><b>Date Prise de service:</b> '.returnannee($prise_service).'</td><td width="300px"><b>Fin de Détachement</b>: '.$dat_eff_det_fin1.' </td><td width="300px"><b>Age </b>:'.$age.' ans  </td></tr>

</table><br><br>'; 
return $ligne_entete_esd;
}*/	
 
	 

