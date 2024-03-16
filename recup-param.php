<?php
if (isset($_GET['id_film'])) {
$id_film = $_GET['id_film'];

// 1. Connexion à la base de donnée db_intro
require './config/db-config.php';

// 2. Préparation de la requête
$requete = $pdo->prepare(query: "SELECT * FROM film WHERE id_film = :id");

// 3. Lier le paramètre
$requete->bindParam(':id', $id_film);

// 4. Exécution de la requête
$requete->execute();

require 'fonction.php'
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Document</title>
</head>
<body class="bg-dark" >
<?php include_once "./_partials/menu.php" ?>
<div class="container ">
    <h1 class="  mt-4" style="color: #86C232; border-bottom: solid; border-bottom-color: #86C232*">Détail du film</h1>
    <div class="table d-flex text-center">
        <div class="mt-3 ">
            <?php
            if ($film = $requete->fetch(PDO::FETCH_ASSOC)) { ?>
            <?php echo "<img src='{$film['image']}' alt='' height='400' </img>"; ?>
        </div>
        <div class="mt-3 text-black p-4 text-start bg-white" >

            <?php
            echo "<p class='fs-4'> {$film['titre']}</p>"; ?>
        <div class="row">
            <?php
            echo "<p class='col-4' ><i class='bi bi-hourglass-split'></i>".convertirEnHeuresMinutes($film['duree'])."</p>";
            echo "<p class='col-4' ><i class='bi bi-calendar me-1'></i>".date("d/m/Y", strtotime($film['date_sortie']))."</p>";
            echo "<p class='col-4' ><i class='bi bi-geo-alt-fill'></i> {$film['pays']}</p>"; ?>
            </div>
            <h3>Synopsis du film :</h3>
            <?php
            echo "<p>{$film['resume']}</p>";
            } else {
                echo "Film introuvable";
            }
            } else {
                echo "Aucun ID de film fourni";
            }
            ?>
        </div>
    </div>
</div>

</body>
</html>