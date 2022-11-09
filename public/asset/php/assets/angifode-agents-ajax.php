<?php
/**
 * @version SVN: $Id: header.php 18 2010-11-08 01:10:19Z elkuku $
 * @package    MARIO
 * @subpackage Base
 * @author     AZEMAFAC NJUKENG ROMARIC
 * @author     Created on 11-Aug-2017
 * @license    GNU/GPL
 */

//-- No direct access
//defined('_JEXEC') || die('=;)');

//jimport('joomla.application.component.controller');

//$fichier =JRequest::getVar( 'chemin_fichier'); 

   include("connect.php");
 $matricule=trim($_GET['matricule']);

	     // Verification si le matricule est inexistant
	     		
	     $query="SELECT  `matricule`,`titre`, `noms`, `prenoms`,`sexe`,`date_naissance` FROM `".$ext."_antilope_agent` ";
	     $query.=" WHERE (matricule='$matricule')" ;
	     $result=$mysqli->query($query);
	     if ($result->num_rows==0){
		  $chaine="-1";  echo $chaine ; mysqli_free_result($result); return;
              }else{	
		  $row = $result->fetch_row();
		  $chaine=utf8_encode($row[0])."#".utf8_encode($row[1])."#".utf8_encode($row[2])."#".utf8_encode($row[3])."#".utf8_encode($row[4])."#".utf8_encode($row[5]);
		 
 
		
	}
		echo $chaine; //json_encode($chaine); // 
		html_entity_decode(json_encode($chaine),ENT_COMPAT,'iso-8859-1') ;
		return;


	return ;

?>
