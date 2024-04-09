<?php
require_once '../base.php';
require_once BASE_PROJET . '/src/database/film-db.php';
require_once BASE_PROJET . '/src/database/user-db.php';
require 'fonction.php';

$id_film=null;
if (isset($_GET['id_film'])) {
    $id_film = filter_var($_GET['id_film'], FILTER_VALIDATE_INT);
}

$requete=getFilmParId($id_film);


session_start();
$utilisateur = null;
if (isset($_SESSION["utilisateur"])) {
    $utilisateur=$_SESSION["utilisateur"];
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Détail du film</title>
    <link rel="shortcut icon" href="/public/assets/images/film.svg">
    <link rel="stylesheet" href="/assets/css/style.css">

</head>
<body class="bg-dark" >
<?php require_once "../base.php";
require_once BASE_PROJET . '/src/_partials/menu.php';
?>
<div class="container ">
    <?php if ($utilisateur) : ?>
        <p class="text-white">Heureux de vous revoir <?= $utilisateur["pseudo_utilisateur"] ?> ♥ </p>
    <?php endif; ?>
    <h1 class="  mt-4" style="color: #86C232; border-bottom: solid; border-bottom-color: #86C232*">Détail du film</h1>
    <div class="table  text-center">
        <div class="mt-3 md ">
            <?php
            if ($film = $requete) : ?>
            <?php echo "<img src='{$film['image']}' alt='' class='card-img' height='400' </img>"; ?>
        </div>
        <div class="mt-3 text-black p-4 text-start  bg-white" >

            <?php
            echo "<p class='fs-4 fw-bold'> {$film['titre']}</p>"; ?>
        <div class="row">
            <?php
            echo "<p class='col-4 fw-bold' ><i class='bi bi-hourglass-split'></i>".convertirEnHeuresMinutes($film['duree'])."</p>";
            echo "<p class='col-4 fw-bold' ><i class='bi bi-calendar me-1'></i>".date("d/m/Y", strtotime($film['date_sortie']))."</p>";
            echo "<p class='col-4 fw-bold' ><i class='bi bi-geo-alt-fill'></i> {$film['pays']}</p>"; ?>
            </div>
            <h3>Synopsis du film :</h3>
            <?php
            echo "<p class='fst-italic'>{$film['resume']}</p>"; ?>
             <p class='fw-bold'>Film crée par : </p><?php $utilisateur=getPseudoUtilisateur($film['id_utilisateur']);
                echo $utilisateur["pseudo_utilisateur"];
             elseif (getFilmParId($id_film) == null) : ?>
        </div>
        <div class="circ">
            <div class="load ">Film introuvable...</div>
            <div class="hands"></div>
            <div class="body"></div>
            <div class="head">
                <div class="eye"></div>
            </div>
        </div>

 <?php endif; ?>

    </div>




</div>

<div class="row align-middle" style="color: #86C232; border-bottom: solid; border-bottom-color: #86C232">
    <div class="col-9 ">
        <h1 class="  text-start mt-2 ">Commentaire</h1>
    </div>
    <?php
    if (!empty($_SESSION)) : ?>
    <div class="col-3 float-sm-end" >
        <a class="btn btn-light"  href="ajout-commentaire.php?id_film=<?= $film['id_film'] ?>">
           Ajouter un commentaire </a>
    </div>
</div>
<?php endif ?>

<script src="assets/js/bootstrap.bundle.min.js"></script>

</body>
</html>