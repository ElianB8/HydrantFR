<?php
session_start();
if(isset($_SESSION['success'])){
require_once("../database.php");
$db = new Database('../install/config.ini');

$donneesbyPage = 15;
$totalDonnees = $db ->  getTotalDonnees();
$totalPages = ceil($totalDonnees/$donneesbyPage);

if(isset($_GET['page']) && !empty($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $totalPages){
    $_GET['page'] = intval($_GET['page']);
    $currentPage = $_GET['page'];
}
else{
    $currentPage = 1;
}

$begin = ($currentPage-1)* $donneesbyPage;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Données</title>
    <!-- BULMA -->
    <link rel="stylesheet" href="../node_modules/bulma/css/bulma.min.css">
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
                <a class="navbar-item" href="../admin.php">
                    Accueil
                </a>
                <a class="navbar-item" href="../poteaux/poteaux.php">
                    Poteaux incendie
                </a>
                <a class="navbar-item">
                    Données
                </a>
                <a class="navbar-item" href="../parametres/parametres.php">
                    Paramètres
                </a>
            </div>
            <div class="navbar-end">
                <div class="navbar-item">
                    <div class="buttons">
                        <a class="navbar-item button is-danger" href="../login/deconnect.php">Deconnexion</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <section class="section">
        <div class="container">
        <div class="has-text-centered">
            <button id="add" class="button is-success" onclick="refs.addModal.open()">
                Ajouter
            </button>
            <button id="del" class="button is-danger" onclick="refs.removeModal.open()">
                Supprimer
            </button>
        </div>
        <br>

            <h1 class="title has-text-centered">Données poteaux incendies</h1>
            <div class="columns">
                <div class="column">
                <nav class="pagination is-centered" role="navigation" aria-label="pagination">
                    <ul class="pagination-list ">
                        <?php
                            for($i = 1;$i<=$totalPages;$i++){
                                if($i == $currentPage){
                        ?>
                            <a class="pagination-link is-current""><?= $i ?></a>
                        <?php
                                }
                                else{
                        ?>
                        <li>
                            <a class="pagination-link" href="donnees.php?page=<?= $i ?>"><?= $i ?></a>
                        </li>
                        <?php
                                }
                            }
                        ?>
                    </ul>
                </nav>

                    <table class="table is-fullwidth is-hoverable is-striped ">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>ID poteau incendies</th>
                                <th>Date</th>
                                <th>Valeur</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $req = $db -> getDonnees($begin,$donneesbyPage);
                                while($data = $req -> fetch()){
                            ?>
                                <tr>
                                    <th><?= $data['id']; ?></th>
                                    <td><?= $data['id_poteau']; ?></td>
                                    <td><?= $data['date']; ?></td>
                                    <td><?= $data['debit']; ?></td>
                                </tr>
                            <?php
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- ADD MODAL -->
        <div class="modal" id="addmodal">
            <div class="modal-background "></div>
            <div class="modal-card ">
                <header class="modal-card-head">
                    <p class="modal-card-title">Ajouter poteau d'incendie</p>
                    <button class="delete" aria-label="close" onclick="refs.addModal.close()"></button>
                </header>
                <section class="modal-card-body">
                    <form method="POST" action="donnees_controller.php">
                        <div class="field">
                            <label class="label">Données</label>
                            <div class="control">
                                <input class="input" type="text" name="don_don">
                            </div>
                            <label class="label">Date</label>
                            <div class="control">
                                <input class="input" type="date" name="don_date">
                            </div>
                            <label class="label">ID poteau incendie</label>
                            <div class="control">
                                <div class="select" > 
                                    <select name="don_id">
                                        <?php
                                            $req_pot = $db -> displayPoteaux();
                                            while($data_pot = $req_pot -> fetch()){
                                        ?>
                                            <option>[<?= $data_pot['id'] ?>] <?= $data_pot['nom'] ?></option>
                                        <?php 
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="button is-success" name="add_saved">Ajouter</button>
                        <a class="button is-danger" onclick="refs.addModal.close()">Annuler</a>
                    </form>
                </section>
            </div>
        </div>
        <!-- REMOVE MODAL -->
        <div class="modal" id="removemodal">
            <div class="modal-background"></div>
            <div class="modal-content">
                <div class="modal-card ">
                    <header class="modal-card-head">
                        <p class="modal-card-title">Supprimer poteau d'incendie</p>
                        <button class="delete" aria-label="close" onclick="refs.removeModal.close()"></button>
                    </header>
                    <section class="modal-card-body">
                        <form method="POST" action="donnees_controller.php">
                            <div class="field">
                                <label class="label">Id</label>
                                <div class="control">
                                    <input class="input" type="text" name="pot_id">
                                </div>
                            </div>
                            <button type="submit" class="button is-success" name="del_saved">Supprimer</button>
                            <a class="button is-danger" onclick="refs.removeModal.close()">Annuler</a>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </section>
    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script>
        var refs = {
            addModal: {
                open: function () {
                    document.getElementById('addmodal').classList.add('is-active');
                },
                close: function () {
                    document.getElementById('addmodal').classList.remove('is-active');
                }
            },
            removeModal: {
                open: function () {
                    document.getElementById('removemodal').classList.add('is-active');
                },
                close: function () {
                    document.getElementById('removemodal').classList.remove('is-active');
                }
            }
        };
    </script>
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