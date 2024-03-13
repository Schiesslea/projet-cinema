<?php
// Récupérer la liste des étudiants dans la table etudiant

// 1. Connexion à la base de donnée db_intro
/**
 * @var PDO $pdo
 */
require './config/db-config.php';

// 2. Préparation de la requête
$requete = $pdo->prepare(query: "SELECT * FROM film");

// 3. Exécution de la requête
$requete->execute();

// 4. Récupération des enregistrements
// Un enregistrement = un tableau associatif
$films = $requete->fetchAll(PDO::FETCH_ASSOC);


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
<?php include_once "./_partials/menu.php" ?>
<body class="" style="background-color: #FFCE32">
<div class="d-flex mt-2">
    <div class=" rounded-4 p-3 flex-fill">
        <div class="container ">
            <h1 class=" border-bottom border-secondary border-3 mb-5 mt-3" style="color: #323232">Liste des films</h1>
            <!-- Votre code -->
            <div class="row text-center " href="#home">
                <?php foreach ($films as $film) : ?>
                    <div class="card border-dark  mb-4 me-2" style="max-width: 20rem; background-color: #1D1D1D">
                        <div class="card-body">
                            <h4 class="card-title"><img src="<?= $film["image"] ?>" alt=""</h4>
                            <p class="card-text fs-3 text-white" ><?= $film["titre"] ?></p>
                            <p class="fs-5 text-white"> <?= "<i class='bi bi-hourglass-split '></i>".convertirEnHeuresMinutes($film["duree"])  ?></p>
                            <p class="card-text">
                                <a class="btn btn-light" role="button"
                                   href="recup-param.php?id_film=<?= $film['id_film'] ?>
                        ">Détails du film</a></p>

                        </div>
                    </div>
                <?php endforeach; ?>
            </div>


</body>
</html>