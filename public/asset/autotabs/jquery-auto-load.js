jQuery.noConflict();
jQuery(document).ready(function($){
	$('#detachement_matricule').change(function() {
		this.value=this.value.toUpperCase();
		return;
	});

	//---- Saisie de Matricule dans le formulaire de détachement
	$('#detachement_matricule').change(function(){
		var matricule =  $('#detachement_matricule').val();
		//alert(matricule)
		//--- ---------------------------------------------------------------
		//alert('Retrait d information du Matricule');
		//----------------------------Connection a la base de donnees pour retrait des valeurs -------------------
		url = "{{asset('asset/autotabs/angifode-agents-ajax.php')}}?matricule="+ matricule;
		   // alert(url);
		$.get(url,
			   function(data){
			  // alert(url);
			   var tablxxx;
			   //alert("Données retournée: "+data);

			   if (data==-1){ // Matricule Inexistant
				 alert("Matricule Inexistant"); $( "#detachement_matricule" ).focus(); return;
				}
			   $("#detachement_matricule" ).css( "background-color", "#d6e89e");
			   //--- activation des champs a remplir
				   // jQuery("#email").removeAttr("disabled");
			   // Extraction des donnees
			   tablxxx=data.split("#");
			   noms=tablxxx[1]; date_nais=tablxxx[2]; date_integ=tablxxx[3];
			   $("#detachement_noms").val(noms);
			   $("#detachement_dateNaissance").val(date_nais);
			   $("#detachement_dateIntegration").val(date_integ);

			   //-- Traitement date de Naissance
			   dnaissance= date_nais.substring(8, 11) +'/'+date_nais.substring(5, 7)+'/'+ date_nais.substring(0, 4);
			   $("#detachement_dateNaissance").val(dnaissance);

			   //-- Traitement date d'intégration
			   dinteg= date_integ.substring(8, 11) +'/'+date_integ.substring(5, 7)+'/'+ date_integ.substring(0, 4);
			   $("#detachement_dateIntegration").val(dinteg);

			   //--- Affectation des variables date diffeent de 0 ou -1
			   //if (sexe=="M"){ $("#sexe").val("1")}else{ $("#sexe").val("2");}
		}) // Get
		return;
	});
});
 
 