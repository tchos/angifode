<?php
$conn = new mysqli('localhost', 'root', 'lolo', 'angifode_db');

if(!$conn){
    die("Error: Erreur de connexion à la base de données !!!");
}

$search = $_GET['term'];

$query = $conn->query("SELECT * FROM `agents` 
    WHERE `noms` 
    LIKE '%".$search."%' 
    ORDER BY `noms` ASC") or die(mysqli_connect_errno());

$list = array();
$rows = $query->num_rows;

if($rows > 0){
    while($fetch = $query->fetch_assoc()){
        $data['value'] = $fetch['noms'];
        array_push($list, $data);
    }
}
echo json_encode($list);
?>
