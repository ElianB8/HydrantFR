<?php
session_start();
    function dbExist(){
    $connection = new mysqli("127.0.0.1","root","");
    if(!$connection){
        die ('Could not connect:' . mysql_error());
    }
    if($connection -> select_db('pompiers')){
        return true;
    }
    else{
        return false;
    }
}
if(isset($_SESSION['success'])){
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Accueil</title>
    <!-- BULMA -->
    <link rel="stylesheet" href="./node_modules/bulma/css/bulma.min.css">
    <link rel="stylesheet" href="./node_modules/leaflet/dist/leaflet.css">
</head>

<body>
    <?php
        if(dbExist()){
    ?>
    <!-- NAVBAR -->
    <nav class="navbar is-dark" role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
            <p class="navbar-item">
                POMPIERS
            </p>

            <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false"
                data-target="navbarBasicExample">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>

        <div id="navbarBasicExample" class="navbar-menu">

            <div class="navbar-start">
                <a class="navbar-item">
                    Accueil
                </a>
                <a class="navbar-item" href="./poteaux/poteaux.php">
                    Poteaux incendie
                </a>
                <a class="navbar-item" href="./donnees/donnees.php">
                    Données
                </a>
                <a class="navbar-item" href="./parametres/parametres.php">
                    Paramètres
                </a>
            </div>

            <div class="navbar-end">
                <div class="navbar-item">
                    <div class="buttons">
                        <a class="navbar-item button is-danger" href="./login/deconnect.php">Deconnexion</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <!-- / NAVBAR -->
    <section class="hero is-link is-fullheight-with-navbar">
        <div id="map" class="hero-body">

        </div>
    </section>
    </section>
    <script src="./node_modules/jquery/dist/jquery.min.js"></script>
    <script src="./node_modules/leaflet/dist/leaflet.js"></script>
    <script src="./js/map.js" ></script>
</body>
        <?php
            }
            else{
                    header('location:./install/install.php');
            }
        ?>

</html>
<?php
}
else{
    header('Location:./login/login.html');
}
?>