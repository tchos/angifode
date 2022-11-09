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
 $matricule=trim($_GET['term']);

	     // Verification si le matricule est inexistant
	     		
	     $query="SELECT  `matricule`,`titre` FROM `".$ext."_antilope_agent` WHERE matricule like '".$matricule."%' order by matricule ASC ";
	     
	     $result=$mysqli->query($query);

	     while ($row = $result->fetch_assoc()) {
	     	// code...
	     	$datax[] = $row['matricule'];
	     }
	      
		  echo json_encode($datax) ;
				return;
 
		/*echo $chaine; //json_encode($chaine); // 
		html_entity_decode(json_encode($chaine),ENT_COMPAT,'iso-8859-1') ;
		return;


	return ;*/

?>
