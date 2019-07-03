<?php
require_once('./database.php');
$db = new Database('./install/config.ini'); 
$db -> mapPoteau();