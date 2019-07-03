<?php
require_once("../database.php");

if(isset($_POST['add_saved'])){
    if(!empty($_POST['don_don']) && !empty($_POST['don_don'])){
        $don_don = htmlspecialchars($_POST['don_don']);
        $don_date = htmlspecialchars($_POST['don_date']);
        $don_id = htmlspecialchars($_POST['don_id']);
        $db = new Database('../install/config.ini'); 
        $start  = strpos($don_id, '[');
        $end    = strpos($don_id, ']', $start + 1);
        $length = $end - $start;
        $result = substr($don_id, $start + 1, $length - 1);
        $db -> addDonnees($result ,$don_don , $don_date);
        header("location:donnees.php");
    }
}

if(isset($_POST['del_saved'])){
    if(!empty($_POST['pot_id'])){
        $pot_id = htmlspecialchars($_POST['pot_id']);
        $db = new Database('../install/config.ini');
        $db -> deleteDonnees($pot_id);
        header('Location:donnees.php');
    }
}