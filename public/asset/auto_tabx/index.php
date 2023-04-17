

<!DOCTYPE html>
<html>
<head>
	<title>ANGIFODE</title>
 

 <!--Voici les elements neccesaire pour l'auto load des donnees dans le formulaire-->
	<link rel="stylesheet" href="assets/css2/jquery-ui-1.10.0.custom.css">
	<link rel="stylesheet" href="assets/css2/ajax.css">
       <script src="assets/js2/jquery-1.9.0.js"></script>
       <script src="assets/js2/jquery-ui-1.10.0.custom.js"></script>
       <!--script src="assets/js2/jquery-auto-load.js"></script-->

<?php //include('auto-list-mat.php'); ?>
<?php //include('connect.php'); 
  ?>

</head>
<body>
 
<table style="width:100%" border = "0">
 
  <tr>
    <td> </td>
    <td><marquee><h6 class="pt-1 text-center">APPLICATION NATIONALE DE GESTION INFORMATIQUE DES FONCTIONNAIRES EN DETACHEMENT</h6> </marquee></td>
    <td> </td>
  </tr>
 
</table>  
 
<div class="container">
	<form  method="post" action="index.php">
		<div class="form-group">
			
			
  
 <label for="nom"> MATRICULE </label><br>
 <input type="text" name="matricule"   id="matricule"  maxlength="7"  autofocus></br>

 <label for="nom"> NOMS DU DETACHE </label><br>
 <input type="text" name="noms" id="noms"    >    <br>
 
 <label for="nom"> DATE OF BIRTH </label><br>
 <input type="text" name="dnaissance" id="dnaissance"   > <br>

 <label for="nom"> ABSORPTION DATE </label><br>
 <input type="text" name="date_int" id="date_int"   > </br>

			<button type="submit" name="showBtn" class="btn btn-success pl-3 pr-3">Afficher</button>

		</div>
		</div>
	</form>
</div>
</body>
</html>

<script>
  

  jQuery.noConflict();

jQuery(document).ready(function($) {
 
 
  
  // *************************************************  *************
  //--- autocomplete 

    $('#matricule').autocomplete( {
    
    minLength: 4,
    delay: 1,
    source: 'http://'+window.location.host+'/auto_tabx/auto_mat.php'
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
      url = 'http://'+window.location.host+'/auto_tabx/auto_data.php?matricule='+ matricule; 
          //alert(url);     
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
         
          //explication de la recuperation des donnees
            //alert(data);
 
           // Extraction des donnees
           tablxxx=data.split("#"); 
           noms=tablxxx[1];date_naiss=tablxxx[2]; date_int1=tablxxx[3]; 
           
           
           //-- Traitement et affichage dans le formulaire

           $("#noms").val(noms); 
           date_int= date_int1.substring(8, 11) +'/'+date_int1.substring(5, 7)+'/'+ date_int1.substring(0, 4);
           $("#date_int").val(date_int);
           dnaissance= date_naiss.substring(8, 11) +'/'+date_naiss.substring(5, 7)+'/'+ date_naiss.substring(0, 4);
           $("#dnaissance").val(dnaissance);
 
 
         
           
          
       }) // Get  
       
      
    return;
    });
     
    });
 
</script>
