<?php
require_once '../base.php';
require_once BASE_PROJET . '/src/database/film-db.php';
$films = getFilms();
require 'fonction.php';

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
    <link rel="stylesheet" href="/assets/css/style.css">

    <title>BestMovie</title>
    <link rel="shortcut icon" href="/public/assets/images/film.svg">
</head>
<?php require_once "../base.php";
require_once BASE_PROJET . '/src/_partials/menu.php';
?>
<body class=" bg-dark" >
        <div class="container ">
            <?php if ($utilisateur) : ?>
                <p class="text-white">Heureux de vous revoir <?= $utilisateur["pseudo_utilisateur"] ?> ♥ </p>
            <?php endif; ?>
            <h1 class="   border-3 mb-5 mt-4" style="color: #86C232; border-bottom: solid ;border-bottom-color: #86C232">Liste des films</h1>
            <!-- Votre code -->
            <div class="row text-center " href="#home">
                <?php foreach ($films as $film) : ?>
                    <div class="card rounded-4  mb-4 me-2" style="max-width: 20rem ">
                        <div class="card-body ">
                            <h4 class="card-title"><img src="<?= $film["image"] ?>" alt=""</h4>
                            <p class="card-text fs-4 text-dark" ><?= $film["titre"] ?></p>
                            <p class="fs-5 text-dark"> <?= "<i class='bi bi-hourglass-split '></i>".convertirEnHeuresMinutes($film["duree"])  ?></p>
                            <p class="card-text">
                                <a class="btn " style="background-color: #86C232 " role="button"
                                   href="detail-film.php?id_film=<?= $film['id_film'] ?>
                        ">Détails du film</a></p>

                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <script src="assets/js/bootstrap.bundle.min.js"></script>

</body>
</html>