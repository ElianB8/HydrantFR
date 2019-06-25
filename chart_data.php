<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
function chartJSON($id_poteau){
    
    $mysqli = new mysqli("127.0.0.1","root","","pompiers");
    if(!$mysqli){
        die("Connection failed: " . $mysqli->error);
    }
    $query =  $mysqli -> prepare("SELECT debit , date FROM donees WHERE id_poteau = ? ORDER BY date ASC");
    $query -> bind_param("i",$id_poteau);
    $query -> execute();
    $result = $query-> get_result();
    while($row = $result -> fetch_assoc()){
        $data[] = $row;
    }
    $result->close();
    $mysqli->close();
    print json_encode($data);
}

chartJSON($_GET['id']);