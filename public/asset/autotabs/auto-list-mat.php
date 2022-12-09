<?php
 
 $mysqli = new mysqli('127.0.0.1', 'root', 'esdbd@pwd', 'angifode');
   if ($mysqli->connect_errno) { die('Connect Error: ' . $mysqli->connect_errno); }
     /* Modification du jeu de résultats en utf8 */
	$mysqli->set_charset("iso-8859-1");
    $ext="psalm23";
 

 $matricule=trim($_GET['term']);

	     // Verification si le matricule est inexistant
	     		
	     $req1x="SELECT  `matricule`,`titre` FROM `".$ext."_antilope_agent` WHERE matricule like '".$matricule."%' order by matricule ASC ";
	     
	     $result1x=$mysqli->query($req1x);

	     while ($row1x = $result1x->fetch_assoc()) {
	     	// code...
	     	$data1x[] = $row1x['matricule'];
	     }
	      
		  echo json_encode($data1x) ;
				return;
 
 

?>
<script>

jQuery.noConflict();

jQuery(document).ready(function($) {
 
 
	
	// *************************************************  *************
	//--- autocomplete 

		$('#matricule').autocomplete( {
 		
 		minLength: 2,
 		delay: 5,
 		source: 'http://'+window.location.host+'/auto_tabs/assets/auto-list-mat.php'
	});
	
	// *******************************************************************
	   
    });
 
 


</script>