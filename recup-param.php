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
    <title>Document</title>
</head>
<body class="bg-dark">
<?php include_once "./_partials/menu.php" ?>
<div class="container">
    <div class="table d-flex text-center">
        <div class="mt-5 ">
            <?php
            if ($film = $requete->fetch(PDO::FETCH_ASSOC)) { ?>
            <?php echo "<img src='{$film['image']}' alt='' height='400' </img>"; ?>
        </div>
        <div class="mt-5 text-white  p-4 text-start">
            <?php
            echo "<p>{$film['titre']}</p>";
            echo "<p>" . convertirEnHeuresMinutes($film['duree']) . "</p>";
            echo "<p>" . date("d/m/Y", strtotime($film['date_sortie'])) . "</p>";
            echo "<p>{$film['pays']}</p>";
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