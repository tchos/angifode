<?php
    $mysqli = new mysqli('127.0.0.1', 'root', 'TKL@wS0CF', 'angifode_db');
    if ($mysqli->connect_errno) { die('Connect Error: ' . $mysqli->connect_errno); }

    ///***************list matricules from database *****************.
    $grade = trim($_GET['term']);
    $req1x = "SELECT  `lib_grade` FROM  grade WHERE lib_grade like '%".$grade."%' order by lib_grade ASC ";
    $result1x = $mysqli->query($req1x);
    while ($row1x = $result1x->fetch_assoc()) {
        // code...
        $data1x[] = $row1x['lib_grade'];
    }
    echo json_encode($data1x) ;
?>
