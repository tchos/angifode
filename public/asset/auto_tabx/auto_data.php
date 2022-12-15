  
<?php


  $mysqli = new mysqli('127.0.0.1', 'root', 'esdbd@pwd', 'angifode_db');
   if ($mysqli->connect_errno) { die('Connect Error: ' . $mysqli->connect_errno); }
     /* Modification du jeu de résultats en utf8 */
 
 
     
 
 //****************************charger les donnees dans les ID javascript****************************************.
 

  $matricule=trim($_GET['matricule']);

       // Verification si le matricule est inexistant
          
       $query="SELECT  `matricule`, `noms`, `date_naissance`,`date_integration` FROM agents ";
       $query.=" WHERE (matricule='$matricule')" ;
       $result=$mysqli->query($query);
       if ($result->num_rows==0){
      $chaine="-1";  echo $chaine ; mysqli_free_result($result); return;
              }else{  
      $row = $result->fetch_row();
      $chaine=utf8_encode($row[0])."#".utf8_encode($row[1])."#".utf8_encode($row[2])."#".utf8_encode($row[3])."#".utf8_encode($row[4])."#".utf8_encode($row[5]);
     
 
    
  }
    echo $chaine; 



  ?>