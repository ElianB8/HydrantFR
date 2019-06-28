<?php
require_once("../database.php");

if(isset($_POST['save_param'])){
    if(!empty($_POST['param_passwd']) && !empty($_POST['conf_param_passwd'])){
        $param_passwd = htmlspecialchars($_POST['param_passwd']);
        $conf_param_passwd = htmlspecialchars($_POST['conf_param_passwd']);
        if(is_numeric($param_passwd) && is_numeric($conf_param_passwd)){
            $db = new Database('127.0.0.1','pompiers','root','');
            if($param_passwd === $conf_param_passwd){
                $db -> changePasswd($param_passwd);
                header('Location:parametres.php');
            }
            else{
                echo "Erreur changement de mot de passe.";
                header('Location:parametres.php');
            }
        }
        else{
            header('Location:parametres.php');
        }
    }
    else{
        header('Location:parametres.php');
    }
}