<?php 
$mysqli = new mysqli('127.0.0.1', 'root', 'esdbd@pwd', 'angifode');
   if ($mysqli->connect_errno) { die('Connect Error: ' . $mysqli->connect_errno); }
     /* Modification du jeu de résultats en utf8 */
	$mysqli->set_charset("iso-8859-1");
    $ext="psalm23";
 ?>
