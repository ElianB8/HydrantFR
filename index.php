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

</html>