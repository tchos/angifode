<?php
 
 $mysqli = new mysqli('127.0.0.1', 'root', 'esdbd@pwd', 'angifode');
   if ($mysqli->connect_errno) { die('Connect Error: ' . $mysqli->connect_errno); }
     /* Modification du jeu de résultats en utf8 */
	$mysqli->set_charset("iso-8859-1");
    $ext="psalm23";
/*****************************************/

 



    /**********************************/ 
 $matricule=trim($_GET['matricule']);

	     // Verification si le matricule est inexistant
	     		
	     $query="SELECT  `matricule`,`titre`, `noms`, `prenoms`,`sexe`,`date_naissance` FROM `".$ext."_antilope_agent` ";
	     $query.=" WHERE (matricule='$matricule')" ;
	     $result=$mysqli->query($query);
	     if ($result->num_rows==0){
		  $chaine="-1";  echo $chaine ; mysqli_free_result($result); return;
              }else{	
		  $row = $result->fetch_row();
		  $chaine=utf8_encode($row[0])."#".utf8_encode($row[1])."#".utf8_encode($row[2])."#".utf8_encode($row[3])."#".utf8_encode($row[4])."#".utf8_encode($row[5]);
		 
 
		
	}
		echo $chaine; //json_encode($chaine); // 
		html_entity_decode(json_encode($chaine),ENT_COMPAT,'iso-8859-1') ;
		return;


	return ;

?>

<script>
jQuery.noConflict();

jQuery(document).ready(function($) {
 
 
	 
	
	$('#matricule').change(function() {
 		
 		this.value=this.value.toUpperCase();
 		return;
	});
	
 
 
 
	//---- Saisie de Matricule dans le formulaire Census
	  $('#matricule').change(function(){
			var matricule =  $('#matricule').val();
			//alert(matricule)
			//--- ---------------------------------------------------------------
			//alert('Retrait d information du Matricule');	
			//----------------------------Connection a la base de donnees pour retrait des valeurs -------------------
			//url = 'http://'+window.location.host+'/auto_tabs/assets/angifode-agents-ajax.php?matricule='+ matricule; 
			   // alert(url);  		
			$.get(matricule,
				   function(data){ 
				  // alert(url); 
				   var tablxxx;
				   //alert("Données retournée: "+data);   
				   			   
				   if (data==-1){ // Matricule Inexistant
					 alert("Matricule Inexistant"); $( "#matricule" ).focus(); return;
				    }
				   $("#matricule" ).css( "background-color", "#d6e89e"); 
				   //--- activation des champs a remplir
				 
				    
				    //jQuery("#email").removeAttr("disabled");
				   // Extraction des donnees
				   tablxxx=data.split("#"); 
				   titre=tablxxx[1];noms=tablxxx[2]; prenoms=tablxxx[3];sexe=tablxxx[4];annee_naiss=tablxxx[5]; 
				   $("#noms").val(noms);$("#prenoms").val(prenoms);  $("#sexe").val(sexe); $("#dnaissance").val(annee_naiss); 
				 
				   
				   

				   //-- Traitement date de Naissance
				   dnaissance= annee_naiss.substring(8, 11) +'/'+annee_naiss.substring(5, 7)+'/'+ annee_naiss.substring(0, 4);
				   $("#dnaissance").val(dnaissance);

				   //--- Affectation des variables date diffeent de 0 ou -1  

				   //if (sexe=="M"){ $("#sexe").val("1")}else{ $("#sexe").val("2");}
				 
				   
				  
			 }) // Get  
			 
			
	  return;
	  });
	   
    });
 
 </script>