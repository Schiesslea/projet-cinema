<?php

require_once '../base.php';
require_once BASE_PROJET . '/src/database/film-db.php';
require_once BASE_PROJET . '/src/database/commentaire-db.php';



session_start();
if (empty($_SESSION)) {
    header("Location: index.php");
}
$utilisateur = null;
if (isset($_SESSION["utilisateur"])) {
    $utilisateur=$_SESSION["utilisateur"];
}
$id_film=null;
if (isset($_GET['id_film'])) {
    $id_film = filter_var($_GET['id_film'], FILTER_VALIDATE_INT);
}

$requete=getFilmParId($id_film);
// Déterminer si le formulaire a été soumis
// Utilisation d'une variable superglobale $_SERVER
// $_SERVER : tableau associatif contenant des informations sur la requête HTTP
$erreurs = [];
$titre = "";
$avis = "";
$note = "";



if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Le formulaire a été soumis !
    // Traiter les données du formulaire
    // Récupérer les valeurs saisies par l'utilisateur
    // Superglobale $_POST : tableau associatif
    $titre = $_POST['titre_commentaire'];
    $avis= $_POST['avis_commentaire'];
    $note = $_POST['note_commentaire'];


    //Validation des données
    if (empty($titre)) {
        $erreurs['titre_commentaire'] = "Le titre est obligatoire";
    }
    if (empty($avis)) {
        $erreurs['avis_commentaire'] = "L'avis est obligatoire";
    }
    if (empty($note)) {
        $erreurs['note_commentaire'] = "La note est obligatoire";
    }
    if ($note < 0 || $note > 5) {
        $erreurs['note_commentaire'] = "La note doit être comprise entre 0 et 5";
    }

    // Traiter les données
    if (empty($erreurs)) {
        postCommentaire($titre, $avis, $note, date("Y/m/d"), date("H:i:s"), $utilisateur["id_utilisateur"], $id_film);
        // Rediriger l'utilisateur vers une autre page du site
        header("Location: /index.php");
        exit();
    }
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
    <title>Ajouter un commentaire</title>
    <link rel="shortcut icon" href="/public/assets/images/film.svg">
    <link rel="stylesheet" href="/assets/css/style.css">

</head>
<body class="bg-dark">
<!--Insertion d'un menu-->
<?php require_once "../base.php";
require_once BASE_PROJET . '/src/_partials/menu.php';
?>
<div class="container">

    <?php if ($utilisateur) : ?>
        <p class="text-white mt-3" >Heureux de vous revoir <?= $utilisateur["pseudo_utilisateur"] ?> ♥ </p>
    <?php endif; ?>
    <?php if (getFilmParId($id_film) == null) : ?>
        <div class="circ">
            <div class="load ">Film introuvable...</div>
            <div class="hands"></div>
            <div class="body"></div>
            <div class="head">
                <div class="eye"></div>
            </div>
        </div>
    <?php else : ?>
    <h1 class="mt-4" style="color: #86C232; border-bottom: solid; border-bottom-color: #86C232">Votre évaluation pour <?= $requete["titre"] ?></h1>
</div>
<div class="container d-flex">
    <img src="assets/images/undraw_home_cinema_l7yl.svg" class="w-25" alt="">

    <div class="w-50 mx-auto shadow my-5  p-4" style="background-color: #86C232">
        <form action="" method="post" novalidate >
            <div class="mb-3">
                <label for="titre_commentaire" class="form-label">Titre*</label>
                <input type="text"
                       class="form-control <?= (isset($erreurs['titre_commentaire'])) ? "border border-2 border-danger" : "" ?>"
                       id="titre_commentaire" name="titre_commentaire" value="<?= $titre ?>" placeholder="Saisir le titre de votre commentaire"
                       aria-describedby="emailHelp">
                <?php if (isset($erreurs['titre_commentaire'])) : ?>
                    <p class="form-text text-danger"><?= $erreurs['titre_commentaire'] ?></p>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="avis_commentaire" class="form-label">Avis*</label>
                <textarea
                       class="form-control <?= (isset($erreurs['avis_commentaire'])) ? "border border-2 border-danger" : "" ?>"
                       id="avis_commentaire"
                       name="avis_commentaire"  placeholder="Saisir votre avis sur le film"
                       aria-describedby="emailHelp"></textarea>
                <?php if (isset($erreurs['avis_commentaire'])) : ?>
                    <p class="form-text text-danger"><?= $erreurs['avis_commentaire'] ?></p>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="note_commentaire" class="form-label">Note*</label>
                <input type="number"
                       class="form-control <?= (isset($erreurs['note_commentaire'])) ? "border border-2 border-danger" : "" ?>"
                       id="note_commentaire"
                       name="note_commentaire" min="0" max="5" value="<?= $note ?>" placeholder="Saisir votre note entre 0 et 5"
                       aria-describedby="emailHelp">
                <?php if (isset($erreurs['note_commentaire'])) : ?>
                    <p class="form-text text-danger"><?= $erreurs['note_commentaire'] ?></p>
                <?php endif; ?>
            </div>
            <p>* Champs obligatoires</p>
            <button type="submit" class="btn btn-light">Valider</button>
        </form>
    </div>
</div>


<?php endif; ?>


<script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>