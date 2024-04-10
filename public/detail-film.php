<?php
require_once '../base.php';
require_once BASE_PROJET . '/src/database/film-db.php';
require_once BASE_PROJET . '/src/database/user-db.php';
require_once BASE_PROJET . '/src/database/commentaire-db.php';
require 'fonction.php';

$id_film=null;
if (isset($_GET['id_film'])) {
    $id_film = filter_var($_GET['id_film'], FILTER_VALIDATE_INT);
}

$requete=getFilmParId($id_film);

$commentaires = getCommentaire($id_film);

session_start();
$utilisateur = null;
if (isset($_SESSION["utilisateur"])) {
    $utilisateur=$_SESSION["utilisateur"];
}

$moyenne_nb_commentaires = getMoyenneNoteEtCommentaire($id_film);

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
            <?php foreach ($moyenne_nb_commentaires as $moyenne_nb_commentaire) : ?>

            <p><?php echo $moyenne_nb_commentaire["moyenne_note"] ?> <?php echo genererEtoiles($moyenne_nb_commentaire["moyenne_note"]) ?>
            <?php if ($moyenne_nb_commentaire["nombre_commentaire"] == null) {
                echo "Aucun commentaire pour ce film...";
            }elseif ($moyenne_nb_commentaire["nombre_commentaire"] == 1) {
                echo $moyenne_nb_commentaire["nombre_commentaire"] ." commentaire";
            }elseif ($moyenne_nb_commentaire["nombre_commentaire"] >1) {
                    echo $moyenne_nb_commentaire["nombre_commentaire"] ." commentaires";
                }?></p>
            <?php endforeach; ?>
            </div>
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
<div class="mt-3 text-black p-4 bg-white" >
<div class="row align-middle" style=" border-bottom: solid; border-bottom-color: #86C232">
    <div class="col-9 ">
        <h1 class="  text-start ">Commentaire</h1>
    </div>
    <?php
    if (!empty($_SESSION)) : ?>
    <div class="col-3" >
        <a class="btn btn-light float-end" style="background-color: #86C232;" href="ajout-commentaire.php?id_film=<?= $film['id_film'] ?>">
           Ajouter un commentaire </a>
    </div>
</div>
<?php endif ?>


    <?php foreach ($commentaires as $commentaire) : ?>

    <div class="row ">
    <?php  $pseudo_commentaire=getPseudoUtilisateur($commentaire['id_utilisateur']); ?>
        <p class="text-start fw-bold fst-italic col-9 mt-1" style="color: #86C232;" > <?php echo $pseudo_commentaire['pseudo_utilisateur'];?></p>
        <p class="text-end col-3 mt-1">écrit le <strong><?php echo  strftime('%d-%m-%Y',strtotime($commentaire['date_commentaire']));?></strong> à <strong><?php echo $commentaire['heure_commentaire']; ?></strong></p>
    </div>
        <p class="fw-bold fs-3 "> <?php echo $commentaire['titre_commentaire'];?>         <button class="float-end btn-dark btn" style="color: #86C232" ><?php echo $commentaire['note_commentaire'] ?><i class="ms-1 bi bi-star-fill" ></i> </button>
        </p>
        <p class="pb-3" style="border-bottom: solid; border-bottom-color: #86C232;"> <?php echo $commentaire['avis_commentaire'];?></p>


    <?php endforeach; ?>

<script src="assets/js/bootstrap.bundle.min.js"></script>

</body>
</html>