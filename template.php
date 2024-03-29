<?php
session_start();
if(isset($_SESSION['success'])){
require_once("database.php");
$db = new Database('./install/config.ini');
if(isset($_GET['id'])){
    if(!$db -> validGetId($_GET['id'])){
        $req = $db -> getUniquePoteau($_GET['id']);
        $data = $req -> fetch();
    }
    else{
        header("Location:./poteaux/poteaux.php");
    }
}
else{
    echo "Erreur champs id vide.";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $data['nom']; ?></title>
    <!-- BULMA -->
    <link rel="stylesheet" href="./node_modules/bulma/css/bulma.min.css">
</head>

<body>
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
                <a class="navbar-item" href="./admin.php">
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
        </div>
    </nav>
    <!-- / NAVBAR -->
    <div class="container" style="margin-bottom:50px;">
        <h1 class="title is-1 has-text-centered"> <?=$data['nom']; ?> </h1>
        <h3 class="title is-3 has-text-centered"> <?=$data['description']; ?> </h3>
    </div>
    <div class="columns">
        <div class="column">
            <table class="table is-hoverable is-stripped is-fullwidth">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>ID poteaux incendies</th>
                        <th>Date</th>
                        <th>Débit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $req_unique_donnees = $db -> getUniqueDonnees($_GET['id']);
                        while($data = $req_unique_donnees -> fetch()){
                    ?>
                        <tr>
                            <th style="color:red;" scope="row"><?= $data['id']; ?></th>
                            <td><?= $data['id_poteau']; ?></td>
                            <td><?= $data['date']; ?></td>
                            <td><?= $data['debit']; ?></td>
                        </tr>
                    <?php
                        }
                    ?>
                </body>
            </table>
        </div>
        <div class="column">
            <div class="chart-container">
                <canvas id="mycanvas"></canvas>
            </div>
        </div>
    </div>
    <script src="./node_modules/jquery/dist/jquery.min.js"></script>
    <script src="./node_modules/chart.js/dist/Chart.min.js"></script>
    <script src="./js/chart.js"></script>
    <script>
        $(document).ready(function() {

        // Check for click events on the navbar burger icon
        $(".navbar-burger").click(function() {

            // Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
            $(".navbar-burger").toggleClass("is-active");
            $(".navbar-menu").toggleClass("is-active");

        });
        });
    </script>
</body>

</html>
<?php
}
else{
    header('Location:../login/login.html');
}
?>