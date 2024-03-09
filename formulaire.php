<?php

/**
 * @var PDO $pdo
 */
require './config/db-config.php';
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
        $erreurs['resume'] = "Le resumé est obligatoire";
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
        // Traitement des données (insertion dans une base de données)
        $requete = $pdo->prepare(query: "INSERT INTO film (titre, duree, resume, date_sortie, pays, image) VALUES (?, ?, ?, ?, ?, ?)");

        $requete->bindParam(1, $titre);
        $requete->bindParam(2, $duree);
        $requete->bindParam(3, $resume);
        $requete->bindParam(4, $date_sortie);
        $requete->bindParam(5, $pays);
        $requete->bindParam(6, $image);

        // 3. Exécution de la requête
        $requete->execute();

        // Rediriger l'utilisateur vers une autre page du site
        header("Location: ../index.php");
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
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Gluten', cursive;
        }
    </style>
    <title>Formulaire</title>
</head>
<body class="bg-dark">
<!--Insertion d'un menu-->
<?php include_once './_partials/menu.php' ?>
<h1 class="text-center text-light">Création d'un film</h1>
<div class="container d-flex">
    <img src="./assets/images/undraw_home_cinema_l7yl.svg" class="w-25" alt="">

    <div class="w-50 mx-auto shadow my-5 p-4 bg-primary ">
        <form action="" method="post" novalidate>
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
                <label for="resume" class="form-label">Resumé*</label>
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
            <button type="submit" class="btn btn-light">Valider</button>
        </form>
    </div>
</div>
</div>


<script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>