<?php
$conn = new mysqli('localhost', 'root', 'TKL@wS0CF', 'angifode_db');

if(!$conn){
    die("Error: Erreur de connexion à la base de données !!!");
}

$search = $_GET['term'];

$query = $conn->query("SELECT * FROM `grade` 
    WHERE `lib_grade` 
    LIKE '%".$search."%' 
    ORDER BY `lib_grade` ASC") or die(mysqli_connect_errno());

$list = array();
$rows = $query->num_rows;

if($rows > 0){
    while($fetch = $query->fetch_assoc()){
        $data['value'] = $fetch['lib_grade'];
        array_push($list, $data);
    }
}
echo json_encode($list);
?>
