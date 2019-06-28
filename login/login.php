<?php
session_start();
require_once('../database.php');
 $db = new Database('127.0.0.1','pompiers','root','');
if($db -> verifyPassword($_POST["pincode"])){
    http_response_code(200);
    $_SESSION['success'] = "OK";
}
else{
    http_response_code(401);
}