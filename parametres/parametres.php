<?php
session_start();
if(isset($_SESSION['success'])){
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Paramètres</title>
    <!-- BULMA -->
    <link rel="stylesheet" href="../node_modules/bulma/css/bulma.min.css">
    <style>
        html{
            background-color: #e2e1e0;
        }

        .card-shadow {
              box-shadow: 0 10px 20px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23);
        }
    </style>
</head>

<body>
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
                <a class="navbar-item" href="../index.php">
                    Accueil
                </a>
                <a class="navbar-item" href="../poteaux/poteaux.php">
                    Poteaux incendie
                </a>
                <a class="navbar-item" href="../donnees/donnees.php">
                    Données
                </a>
                <a class="navbar-item">
                    Paramètres
                </a>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="columns">
            <div class="column">
                <div style="margin-top:25px;" class="card card-shadow">
                    <header class="card-header">
                        <p class="card-header-title">
                            Général
                        </p>
                    </header>
                    <div class="card-content">
                        <div class="content">
                            <h4 class="is-title is-4">Ville</h4>
                        </div>
                    </div>
                    <footer class="card-footer">
                        <a href="#" class="card-footer-item">Save</a>
                        <a href="#" class="card-footer-item">Edit</a>
                        <a href="#" class="card-footer-item">Delete</a>
                    </footer>
                </div>
            </div>
            <div class="column">

            </div>
        </div>
    </div>
</body>

</html>
<?php
}
else{
    header('Location:../login/login.html');
}
?>