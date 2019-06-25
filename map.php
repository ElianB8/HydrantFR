<?php
$mysqli = new mysqli("127.0.0.1","root","","pompiers");
if(!$mysqli){
    die("Connection failed: " . $mysqli->error);
}
$query =  $mysqli ->prepare("SELECT * FROM poteau");
$query -> execute();
$result = $query-> get_result();
while($row = $result -> fetch_assoc()){
    $data[] = $row;
}
$result->close();
$mysqli->close();
echo json_encode($data);
