jQuery.noConflict();

jQuery(document).ready(function($) {
	
	// ************************************************* Script de changement de valeur dans l'input **************
	//--- autocomplete 

		$('#matricule').autocomplete( {
 		
 		minLength: 4,
 		delay: 2,
 		source: "{{ asset('asset/php/auto_complete_tabul/auto-list-mat.php') }}"
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
			url = 'http://'+window.location.host+'/pdf_reports/assets/angifode-agents-ajax.php?matricule='+ matricule; 
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
				    
				    //jQuery("#email").removeAttr("disabled");
				   // Extraction des donnees
				   tablxxx=data.split("#"); 
				   noms=tablxxx[1]; date_naissance=tablxxx[2]; date_integration=tablxxx[3];

				   $("#detachement_noms").val(noms);
				   $("#detachement_dateNaissance").val(date_naissance);
				   $("#detachement_dateIntegration").val(date_integration);
			 }) // Get  
			//-------------------------------------------------------------------- Affectation des valeurs
			
			
	  return;
	  });
	   
    });
 
 
