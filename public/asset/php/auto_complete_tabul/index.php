

<!DOCTYPE html>
<html>
<head>
	<title>ANGIFODE</title>
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!--<link rel="stylesheet" href="assets/css/style.css">-->
    <link rel="stylesheet" type="text/css" href="assets/css/dataTables.bootstrap4.min.css">


 <!--Voici les elements neccesaire pour l'auto load des donnees dans le formulaire-->
	<link rel="stylesheet" href="assets/css2/jquery-ui-1.10.0.custom.css">
	<link rel="stylesheet" href="assets/css2/ajax.css">
       <script src="assets/js2/jquery-1.9.0.js"></script>
       <script src="assets/js2/jquery-ui-1.10.0.custom.js"></script>
       <script src="assets/js2/jquery-auto-load.js"></script>
</head>
<body>
<?php require 'entete.php'; ?>
<div class="container">
	<form  method="post" action="index.php">
		<div class="form-group">
			
			
  
 <label for="nom"> MATRICULE </label><br>
 <input type="text" name="matricule" placeholder="ENTRE LE MATRICULE SOLDE" class="form-control mr-4" id="matricule"  maxlength="7"  autofocus
value="<?php  if(!empty($matricule)){echo $matricule;}?>"></br>

 <label for="nom"> NOMS DU DETACHE </label><br>
 <input type="text" name="noms" id="noms"  disabled value="<?php  if(!empty($matricule)){echo $noms;}?>" class="form-control mr-3"> <br>

 <label for="nom"> PRENOMS DU DETACHE </label><br>
 <input type="text" name="prenoms" id="prenoms"   value="<?php  if(!empty($matricule)){echo $prenoms;}?>" disabled  class="form-control mr-3"> <br>

 <label for="nom"> DATE OD BIRTH </label><br>
 <input type="text" name="dnaissance" id="dnaissance"   value="<?php  if(!empty($matricule)){echo $date_naissance;}?>" disabled  class="form-control mr-3"> <br>

 <label for="nom"> SEXE </label><br>
 <input type="text" name="sexe" size="1" id="sexe" max="1" min="1" maxlength="1" value="<?php  if(!empty($matricule)){if($sexe=='M'){echo '1';}else{echo '2';}}?>"  disabled class="form-control mr-3" > </br>

			<button type="submit" name="showBtn" class="btn btn-success pl-3 pr-3">Afficher</button>

		</div>
		</div>
	</form>
</div>
</body>
</html>

