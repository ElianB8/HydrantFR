<?php

//Création BDD
function createDB(){
    try {
        $conn = new PDO("mysql:host=127.0.0.1","root","");
        $sql = "CREATE DATABASE IF NOT EXISTS pompiers";
        $conn -> exec($sql);
        return true;
    } catch (Exception $e) {
        die('Erreur : '.$e->getMessage());
        return false;
    }
}


require_once('../database.php');
if(isset($_POST['install'])){
    $codepin = htmlspecialchars($_POST['codepin']);
    $confcodepin = htmlspecialchars($_POST['confcodepin']);
    if(!empty($codepin) && !empty($confcodepin) && $codepin === $confcodepin){
        if(createDB()){
            $db = new Database('127.0.0.1','pompiers','root','');
            if($db -> createTablePassword() && $db -> createTableDonnees() && $db -> createTablePoteau() ){
                $db -> addPasswd($codepin);
                $msg = "Création table réussie !";
                header('Location:../index.php');   
            }
            else{
                $errors = array($db -> createTableDonnees() , $db -> createTablePoteau()) ;
            }
        }
        else{
            echo "Erreur création base de données!";
        }
        
    }
    else{
        echo "Champ vide";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Installation</title>
    <!-- BULMA -->
    <link rel="stylesheet" href="../node_modules/bulma/css/bulma.min.css">
</head>

<body>
    <div class="container">
        <div class="columns">
            <div class="column has-text-centered">
                <br>
                <br>
                <form method="POST" class="has-text-centered">
                    <div class="columns">
                        <div class="column">
                            <div class="field">
                                <label class="label">Code Pin</label>
                                <div class="control">
                                    <input class="input" type="password" name="codepin" maxlength="6" required>
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="field">
                                <label class="label">Confirmer Code Pin</label>
                                <div class="control">
                                    <input class="input" type="password" name="confcodepin" maxlength="6" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <br>
                    <div class="control">
                        <button type="submit" class="button is-link" name="install">Installer</button>
                    </div>
                </form>
                <br>
                <h5 class="title is-5 has-text-success">
                    <?php 
                if(isset($msg)){
                    echo $msg;
                }
            ?>
                </h5>
                <h5 class="title is-5 has-text-danger">
                    <?php 
                if(isset($errors)){
                    foreach($errors as $error){
                        echo $errors[0];
                    }
                } 
            ?>
                </h5>

            </div>
        </div>
    </div>

</body>

</html>