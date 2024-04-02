<?php

require_once '../base.php';
require_once BASE_PROJET . '/src/database/film-db.php';

session_start();
if (empty($_SESSION)) {
    header("Location: index.php");
}
// Déterminer si le formulaire a été soumis
// Utilisation d'une variable superglobale $_SERVER
// $_SERVER : tableau associatif contenant des informations sur la requête HTTP
$erreurs = [];
$titre = "";
$duree = "";
$resume = "";
$date_sortie = "";
$pays = "";
$image = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Le formulaire a été soumis !
    // Traiter les données du formulaire
    // Récupérer les valeurs saisies par l'utilisateur
    // Superglobale $_POST : tableau associatif
    $titre = $_POST['titre'];
    $duree = $_POST['duree'];
    $resume = $_POST['resume'];
    $date_sortie = $_POST['date_sortie'];
    $pays = $_POST['pays'];
    $image = $_POST['image'];

    //Validation des données
    if (empty($titre)) {
        $erreurs['titre'] = "Le titre est obligatoire";
    }
    if (empty($duree)) {
        $erreurs['duree'] = "La durée est obligatoire";
    }
    if (empty($resume)) {
        $erreurs['resume'] = "Le résumé est obligatoire";
    }
    if ($duree < 0) {
        $erreurs['duree'] = "La durée n'est pas valide";
    }
    if (empty($date_sortie)) {
        $erreurs['date_sortie'] = "La date de sortie est obligatoire";
    }
    if (empty($pays)) {
        $erreurs['pays'] = "Le pays est obligatoire";
    }
    if (empty($image)) {
        $erreurs['image'] = "L'image est obligatoire";
    } elseif (!filter_var($image, FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED)) {
        $erreurs['image'] = "Le lien de l'image n'est pas valide";
    }

    // Traiter les données
    if (empty($erreurs)) {
        postFilm($titre, $duree, $resume, $date_sortie, $pays, $image);
        // Rediriger l'utilisateur vers une autre page du site
        header("Location: /index.php");
        exit();
    }
}


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
    <link rel="stylesheet" href="/public/assets/css/style.css">

    <title>Ajouter un film</title>
    <link rel="shortcut icon" href="/public/assets/images/film.svg">

</head>
<body class="bg-dark">
<!--Insertion d'un menu-->
<?php require_once "../base.php";
require_once BASE_PROJET . '/src/_partials/menu.php';
?>
<div class="container">
    <?php if ($utilisateur) : ?>
        <p class="text-white"><?= $utilisateur["pseudo_utilisateur"] ?> êtes connecté en tant que goat ♥ </p>
    <?php endif; ?>
<h1 class="mt-4" style="color: #86C232; border-bottom: solid; border-bottom-color: #86C232">Ajouter un film</h1>
</div>
<div class="container d-flex">
    <img src="assets/images/undraw_home_cinema_l7yl.svg" class="w-25" alt="">

    <div class="w-50 mx-auto shadow my-5  p-4" style="background-color: #86C232">
        <form action="" method="post" novalidate >
            <div class="mb-3">
                <label for="titre" class="form-label">Titre*</label>
                <input type="text"
                       class="form-control <?= (isset($erreurs['titre'])) ? "border border-2 border-danger" : "" ?>"
                       id="titre" name="titre" value="<?= $titre ?>" placeholder="Saisir le titre du film"
                       aria-describedby="emailHelp">
                <?php if (isset($erreurs['titre'])) : ?>
                    <p class="form-text text-danger"><?= $erreurs['titre'] ?></p>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="duree" class="form-label">Durée*</label>
                <input type="number"
                       class="form-control <?= (isset($erreurs['duree'])) ? "border border-2 border-danger" : "" ?>"
                       id="duree"
                       name="duree" value="<?= $duree ?>" placeholder="Saisir la durée du film"
                       aria-describedby="emailHelp">
                <?php if (isset($erreurs['duree'])) : ?>
                    <p class="form-text text-danger"><?= $erreurs['duree'] ?></p>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="resume"  class="form-label">Resumé*</label>
                <input type="text"
                       class="form-control <?= (isset($erreurs['resume'])) ? "border border-2 border-danger" : "" ?>"
                       id="resume" name="resume" value="<?= $resume ?>" placeholder="Saisir le résumé du film"
                       aria-describedby="emailHelp">
                <?php if (isset($erreurs['resume'])) : ?>
                    <p class="form-text text-danger"><?= $erreurs['resume'] ?></p>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="date_sortie" class="form-label">Date de sortie*</label>
                <input type="date"
                       class="form-control  <?= (isset($erreurs['date_sortie'])) ? "border border-2 border-danger" : "" ?>"
                       id="date_sortie" name="date_sortie" value="<?= $date_sortie ?>"
                       placeholder="Saisir la date de sortie"
                       aria-describedby="emailHelp">
                <?php if (isset($erreurs['date_sortie'])) : ?>
                    <p class="form-text text-danger"><?= $erreurs['date_sortie'] ?></p>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="pays" class="form-label">Pays*</label>
                <input type="text"
                       class="form-control <?= (isset($erreurs['pays'])) ? "border border-2 border-danger" : "" ?>"
                       id="pays" name="pays" value="<?= $pays ?>" placeholder="Saisir le pays"
                       aria-describedby="emailHelp">
                <?php if (isset($erreurs['pays'])) : ?>
                    <p class="form-text text-danger"><?= $erreurs['pays'] ?></p>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image*</label>
                <input type="url"
                       class="form-control <?= (isset($erreurs['image'])) ? "border border-2 border-danger" : "" ?>"
                       id="image" name="image" value="<?= $image ?>" placeholder="Saisir un lien pour l'image du film"
                       aria-describedby="emailHelp">
                <?php if (isset($erreurs['image'])) : ?>
                    <p class="form-text text-danger"><?= $erreurs['image'] ?></p>
                <?php endif; ?>
            </div>
            <p>* Champs obligatoires</p>
            <button type="submit" class="btn btn-light">Valider</button>
        </form>
    </div>
</div>
</div>


<script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>