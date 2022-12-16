<?php

$mysqli = new mysqli('localhost', 'root', 'TKL@wS0CF', 'angifode_db');
if ($mysqli->connect_errno) { die("Error: Erreur de connexion à la base de données !!!"); }

/* Modification du jeu de résultats en utf8 */
//$mysqli->set_charset("iso-8859-1");

$matricule = trim($_GET['term']);

// Verification si le matricule est inexistant
	     		
$req1x = ("SELECT * FROM `agents` 
    WHERE `matricule` 
    LIKE '%".$matricule."%' 
    ORDER BY `matricule` ASC");
	     
$result1x = $mysqli->query($req1x);

while ($row1x = $result1x->fetch_assoc()) {    $data1x[] = $row1x['matricule'];    }
echo json_encode($data1x) ;
return;

?>