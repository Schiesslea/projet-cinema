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
<body>
    <table class="table table-primary">
        <thead>
        <tr>
            <th class="text-warning" scope="col">Affiche</th>
            <th class="text-warning" scope="col">Titre</th>
            <th class="text-warning" scope="col">Durée du film</th>
            <th class="text-warning" scope="col">Détail du film</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($films as $film) : ?>
            <tr>
                <td><img src="<?= $film["image"] ?>" alt=""></td>
                <td><?= $film["titre"] ?></td>
                <td><?= $film["duree"] ?></td>
                <td><a href="recup-param.php?id_film=<?= $film['id_film'] ?>">Détails du film</a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
        </table>
</body>
</html>