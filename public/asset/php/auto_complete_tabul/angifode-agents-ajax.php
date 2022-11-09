<?php
/**
 * @version SVN: $Id: header.php 18 2010-11-08 01:10:19Z elkuku $
 * @package    MARIO
 * @subpackage Base
 * @author     AZEMAFAC NJUKENG ROMARIC
 * @author     Created on 11-Aug-2017
 * @license    GNU/GPL
 */
 include("connect.php");
 $matricule=trim($_GET['matricule']);

	     // Verification si le matricule est inexistant
	     		
	     $query="SELECT matricule, noms,date_naissance,date_integration FROM agents";
	     $query.=" WHERE (matricule='$matricule')" ;
	     $result=$mysqli->query($query);
	     if ($result->num_rows==0){
		  $chaine="-1";  echo $chaine ; mysqli_free_result($result); return;
              }else{	
		  $row = $result->fetch_row();
		  $chaine=utf8_encode($row[0])."#".utf8_encode($row[1])."#".utf8_encode($row[2])."#".utf8_encode($row[3]);
	}
		echo $chaine; //json_encode($chaine); // 
		html_entity_decode(json_encode($chaine),ENT_COMPAT,'iso-8859-1') ;
		return;


	return ;

?>
