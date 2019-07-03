<?php
session_start();
require_once('../database.php');
 $db = new Database("../install/config.ini");
if($db -> verifyPassword($_POST["pincode"])){
    http_response_code(200);
    $_SESSION['success'] = "OK";
}
else{
    http_response_code(401);
}