<?php
    // Connexion à la bd angifode_db:
    $mysqli = new mysqli('localhost', 'root', 'TKL@wS0CF', 'angifode_db');
    if ($mysqli->connect_errno) { die("Error: Erreur de connexion à la base de données !!!"); }

     $matricule = trim($_GET['matricule']);
    // Verification si le matricule est inexistant
    $query = "SELECT  `matricule`,`noms`, `date_naissance`,`date_integration` FROM `agents` ";
    $query .= " WHERE (matricule='$matricule')" ;
    $result = $mysqli->query($query);
    if ($result->num_rows == 0) {
        $chaine="-1";  echo $chaine ; mysqli_free_result($result); return;
    } else {
        $row = $result->fetch_row();
        $chaine = utf8_encode($row[0])."#".utf8_encode($row[1])."#".utf8_encode($row[2])."#".utf8_encode($row[3]);
    }

    echo $chaine; //json_encode($chaine); //
    //html_entity_decode(json_encode($chaine),ENT_COMPAT,'iso-8859-1') ;
    //return;
?>