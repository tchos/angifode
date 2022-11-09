jQuery.noConflict();

jQuery(document).ready(function($) {
 
	//-------------------------------------------------------------------------------------------------------------
	// *********************************************************************** Script autocomplete ---------------
	//------------------------------------------------------------------------------------------------------------	
	     //------
	    $( "#gra_rec" ).autocomplete({  
	      minLength: 2 ,
	      delay: 200 ,
	      source: 'http://'+window.location.host+'/components/com_angifode/scripts/angifode-search-grade.php'
    	    });
    	  
    	       //------
	    $( "#gra_det" ).autocomplete({  
	      minLength: 2 ,
	      delay: 200 ,
	      source: 'http://'+window.location.host+'/components/com_angifode/scripts/angifode-search-grade.php'
    	    });
	     
         //------
	    $( "#ministere" ).autocomplete({  
	      minLength: 2 ,
	      delay: 200 ,
	      source: 'http://'+window.location.host+'/components/com_angifode/scripts/angifode-search-ministere.php'
    	    });
	     
	 //------------------------------------------------------------------------------------------------------------	
	      $( "#organisme" ).autocomplete({ 
	            minLength: 2,
	            delay: 200 ,
	            source: 'http://'+window.location.host+'/components/com_angifode/scripts/angifode-search-organisme.php' 
	            });
	    
		
		
	
	// ************************************************* Script de changement de valeur dans l'input **************
	//--- autocomplete 

		$('#matricule').autocomplete( {
 		
 		minLength: 4,
 		delay: 5,
 		source: 'http://'+window.location.host+'/pdf_reports/assets/auto-list-mat.php'
	});
	
	// ************************************************************************************************************

	
	$('#matricule').change(function() {
 		
 		this.value=this.value.toUpperCase();
 		return;
	});
	
	$('#email').change(function() {
 		 
 		 var sEmail = $('#email').val();
 		 var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
 		 //alert(sEmail)
        if ($.trim(sEmail).length != 0) {
            if (!filter.test(sEmail)) {
            	alert('Invalid Email Address');
            	e.preventDefault();
        			return true;
    			}
 
        }
	});
 
	//--- Grade
	
	$('#gra_det').change(function(){
		var grade =  $('#gra_det').val();
		url = 'http://'+window.location.host+'/components/com_angifode/scripts/angifode-grade.php?grade='+ grade; 
		$.get(url,
				   function(data){ 
				   //alert(data);   
				   $("#gra_det_h").val(data);
				   
			 }) // Get 
		
	}); // End of $('#l').change(function(){	
	
	$('#gra_rec').change(function(){
		var grade =  $('#gra_rec').val();
		url = 'http://'+window.location.host+'/components/com_angifode/scripts/angifode-grade.php?grade='+ grade; 
		$.get(url,
				   function(data){ 
				   //alert(data);   
				   $("#gra_rec_h").val(data);
				   
			 }) // Get 
		
	}); // End of $('#l').change(function(){
		
	 
	
	//--- Lieu d'Affectation
	$('#ministere').change(function(){
		var ministere =  $('#ministere').val(); //alert(ministere);
		url = 'http://'+window.location.host+'/components/com_angifode/scripts/angifode-ministere.php?ministere='+ ministere; 
		$.get(url,
				   function(data){ 
				   //alert(url); 
				   var tablxxx;
				   //alert("Données retournée: "+data);   
				   tablxxx=data;
				   $("#ministere_h").val(data); 
				   
			 }) // Get 
		
	}); // End of $('#l').change(function(){	
   //--- Arrondissement
   $('#organisme').change(function(){
		var organisme =  $('#organisme').val(); //alert(organisme);
		url = 'http://'+window.location.host+'/components/com_angifode/scripts/angifode-organisme.php?organisme='+ organisme; 
		$.get(url,
				   function(data){ 
				   //alert(url); 
				   var tablxxx;
				   //alert("Données retournée: "+data);   
				   tablxxx=data;
				   $("#organisme_h").val(data); 
				   
			 }) // Get 
		
	});  //$('#organisme').change(function(){
	//--- Lieu de Naissance
	//--- Presence Effective
    
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
				   //--- activation des champs a remplir
				   //--activate_input();
				    $("#tel").removeAttr("disabled"); $("#status").removeAttr("disabled");$("#email").removeAttr("disabled");
					 $("#cni").removeAttr("disabled");$("#ref_act").removeAttr("disabled");$("#dat_int").removeAttr("disabled");
					 $("#type_acte").removeAttr("disabled");				    
				    $( "#status" ).focus(); 
				    
				    //jQuery("#email").removeAttr("disabled");
				   // Extraction des donnees
				   tablxxx=data.split("#"); 
				   titre=tablxxx[1];noms=tablxxx[2]; prenoms=tablxxx[3];sexe=tablxxx[4];annee_naiss=tablxxx[5];
				   chapitre=tablxxx[6]; sigle_ministere=tablxxx[7]; libelle_ministere=tablxxx[8]; grade=tablxxx[9];
				   libelle_grade=tablxxx[10];categorie=tablxxx[11];classe=tablxxx[12];echelon=tablxxx[13];indice=tablxxx[14]; 
				   $("#noms").val(noms);$("#prenoms").val(prenoms);  $("#sexe").val(sexe); $("#dnaissance").val(annee_naiss); 
				   

				   /*$("#gra_rec").val(libelle_grade); $("#gra_rec_h").val(grade); $("#cat_rec").val(categorie); 
				   $("#cla_rec").val(classe); $("#ech_rec").val(echelon); $("#ind_rec").val(indice);
				   $("#ministere").val(sigle_ministere);$("#ministere_h").val(chapitre); 
				   $("#gra_det").val(libelle_grade); $("#gra_det_h").val(grade); $("#cat_det").val(categorie); 
					$("#cla_det").val(classe); $("#ech_det").val(echelon); $("#ind_det").val(indice);*/
				   
				   

				   //-- Traitement date de Naissance
				   dnaissance= annee_naiss.substring(8, 11) +'/'+annee_naiss.substring(5, 7)+'/'+ annee_naiss.substring(0, 4);
				   $("#dnaissance").val(dnaissance);

				   //--- Affectation des variables date diffeent de 0 ou -1  

				   if (sexe=="M"){ $("#sexe").val("1")}else{ $("#sexe").val("2");}
				 
				   
				   //return;
			 }) // Get  
			//-------------------------------------------------------------------- Affectation des valeurs
			
			
	  return;
	  });
	   
    });
 
 