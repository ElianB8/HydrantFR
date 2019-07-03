<?php

require_once("../database.php");

if(isset($_POST['add_saved'])){
        if(!empty($_POST['pot_name']) && !empty($_POST['pot_description']) && !empty($_POST['pot_adresse']) && !empty($_POST['pot_latitude']) && !empty($_POST['pot_longitude']) ){
        $pot_name = htmlspecialchars($_POST['pot_name']);
        $pot_des = htmlspecialchars($_POST['pot_description']);
        $pot_adresse = htmlspecialchars($_POST['pot_adresse']);
        $pot_latitude = htmlspecialchars($_POST['pot_latitude']);
        $pot_longitude = htmlspecialchars($_POST['pot_longitude']);
        $pot_adresse_noaccent = str_to_noaccent($pot_adresse);
        $pot_name_noaccent = str_to_noaccent($pot_name);
        $db = new Database('../install/config.ini');
        $db -> addPoteaux($pot_name_noaccent , $pot_des,$pot_adresse_noaccent,$pot_latitude,$pot_longitude);
        header('Location:poteaux.php');
    }
}

if(isset($_POST['del_saved'])){
    if(!empty($_POST['pot_id'])){
        $pot_id = htmlspecialchars($_POST['pot_id']);
        $db = new Database('../install/config.ini');
        $db -> deletePot($pot_id);
        header('Location:poteaux.php');
    }
}

function str_to_noaccent($str)
{
    $str = preg_replace('#Ç#', 'C', $str);
    $str = preg_replace('#ç#', 'c', $str);
    $str = preg_replace('#è|é|ê|ë#', 'e', $str);
    $str = preg_replace('#È|É|Ê|Ë#', 'E', $str);
    $str = preg_replace('#à|á|â|ã|ä|å#', 'a', $str);
    $str = preg_replace('#@|À|Á|Â|Ã|Ä|Å#', 'A', $str);
    $str = preg_replace('#ì|í|î|ï#', 'i', $str);
    $str = preg_replace('#Ì|Í|Î|Ï#', 'I', $str);
    $str = preg_replace('#ð|ò|ó|ô|õ|ö#', 'o', $str);
    $str = preg_replace('#Ò|Ó|Ô|Õ|Ö#', 'O', $str);
    $str = preg_replace('#ù|ú|û|ü#', 'u', $str);
    $str = preg_replace('#Ù|Ú|Û|Ü#', 'U', $str);
    $str = preg_replace('#ý|ÿ#', 'y', $str);
    $str = preg_replace('#Ý#', 'Y', $str);
     
    return ($str);
}