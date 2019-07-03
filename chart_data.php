<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
require_once('database.php');
$db = new Database('./install/config.ini'); 
$db -> chartJSON($_GET['id']);