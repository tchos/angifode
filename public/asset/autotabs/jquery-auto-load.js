jQuery.noConflict();

jQuery(document).ready(function($) {
 
 
	
	// *************************************************  *************
	//--- autocomplete 

		$('#matricule').autocomplete( {
 		
 		minLength: 4,
 		delay: 5,
 		source: 'http://'+window.location.host+'/auto_tabs/assets/auto-list-mat.php'
	});
	
	// ************************************************************************************************************

	
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
			url = 'http://'+window.location.host+'/auto_tabs/assets/angifode-agents-ajax.php?matricule='+ matricule; 
			   // alert(url);  		
			$.get(url,
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
 
 