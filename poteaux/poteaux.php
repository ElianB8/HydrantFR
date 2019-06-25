<?php
require_once("../database.php");
$db = new Database('127.0.0.1','pompiers','root','');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Poteaux incendies</title>
    <!-- BULMA -->
    <link rel="stylesheet" href="../node_modules/bulma/css/bulma.min.css">
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
                <a class="navbar-item" href="../index.php">
                    Accueil
                </a>
                <a class="navbar-item">
                    Poteaux incendie
                </a>
                <a class="navbar-item" href="../donnees/donnees.php">
                    Données
                </a>
            </div>
            <div class="navbar-end">
                <div class="navbar-item">
                    <div class="buttons">

                    </div>
                </div>
            </div>
        </div>
    </nav>
    <!-- / NAVBAR -->
    <!-- SECTION -->
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

            <h1 class="title has-text-centered">Poteaux d'incendies</h1>
            <div class="columns">
                <div class="column">
                    <table class="table is-fullwidth is-hoverable is-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Adresse</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $req = $db -> getPoteaux();
                                while($data = $req -> fetch()){
                            ?>
                                <tr>
                                    <th><?= $data['id']; ?></th>
                                    <td><a href="../template.php?id=<?= $data['id']?>"><?= $data['nom']; ?></a></td>
                                    <td><?= $data['adresse']; ?></td>
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
                    <form method="POST" action="poteaux_controller.php">
                        <div class="field">
                            <label class="label">Nom</label>
                            <div class="control">
                                <input class="input" type="text" name="pot_name">
                            </div>
                            <label class="label">Description</label>
                            <div class="control">
                                <input class="input" type="text" name="pot_description">
                            </div>
                            <label class="label">Adresse</label>
                            <div class="control">
                                <input class="input" type="text" name="pot_adresse" id="pot_adresse">
                            </div>
                            <div class="columns">
                                <div class="column">
                                    <label class="label">Latitude</label>
                                    <div class="control">
                                        <input class="input" type="text" name="pot_latitude" id="pot_latitude" readonly>
                                    </div>
                                </div>
                                <div class="column">
                                    <label class="label">Longitude</label>
                                    <div class="control">
                                        <input class="input" type="text" name="pot_longitude" id="pot_longitude" readonly>
                                    </div>
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
                        <form method="POST" action="poteaux_controller.php">
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
    <script src="../js/poteaux.js" ></script>
</body>

</html>