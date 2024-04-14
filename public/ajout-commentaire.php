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
$commentaires = getCommentaire($id_film);
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
    if ($note < 0 || $note > 5) {
        $erreurs['note_commentaire'] = "La note doit être comprise entre 0 et 5";
    }
    foreach ($commentaires as $commentaire) {
        if ($utilisateur["id_utilisateur"] == $commentaire["id_utilisateur"]) {
            $erreurs['commentaire_existe'] = "Vous avez déjà posté un commentaire";
        }
    }

    // Traiter les données
    if (empty($erreurs)) {
        postCommentaire($titre, $avis, $note, date("Y/m/d"), date("H:i:s"), $utilisateur["id_utilisateur"], $id_film);
        // Rediriger l'utilisateur vers une autre page du site
        header("Location: detail-film.php?id_film=$id_film");
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

    <div class="w-50 mx-auto shadow my-5  p-4" style="background-color: #86C232">
        <p class="text-danger text-center">Attention, vous pouvez poster que un commentaire par film</p>
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
            <?php if (isset($erreurs['commentaire_existe'])) : ?>
            <p> <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"><style>@keyframes n-info-tri{0%,to{transform:rotate(0deg);transform-origin:center}10%,90%{transform:rotate(2deg)}20%,40%,60%{transform:rotate(-6deg)}30%,50%,70%{transform:rotate(6deg)}80%{transform:rotate(-2deg)}}.prefix__n-info-tri{animation:n-info-tri .8s cubic-bezier(.455,.03,.515,.955) both infinite}</style><path class="prefix__n-info-tri" style="animation-delay:1s" stroke="#0A0A30" stroke-width="1.5" d="M11.134 6.844a1 1 0 011.732 0l5.954 10.312a1 1 0 01-.866 1.5H6.046a1 1 0 01-.866-1.5l5.954-10.312z"/><g class="prefix__n-info-tri"><path stroke="#265BFF" stroke-linecap="round" stroke-width="1.5" d="M12 10.284v3.206"/><circle cx="12" cy="15.605" r=".832" fill="#265BFF"/></g></svg><?= $erreurs['commentaire_existe'] ?></p>
            <?php endif; ?>
            <p>* Champs obligatoires</p>
            <button type="submit" class="btn btn-light">Valider</button>
        </form>
    </div>
    <img src="assets/images/undraw_reviews_lp8w.svg" class="w-25" alt="">

</div>


<?php endif; ?>


<script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>