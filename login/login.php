<?php
session_start();
if($_POST["pincode"] === "230192"){
    http_response_code(200);
    $_SESSION['success'] = "OK";
}
else{
    http_response_code(401);
}