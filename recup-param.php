<?php
// Récupère le paramètre d'URL 'prenom'
// Tester la présence du paramètre
// Récupère le paramètre d'URL 'prenom'
// Tester la présence du paramètre
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

    // 5. Récupération du film (vérifier si trouvé)
    if ($film = $requete->fetch(PDO::FETCH_ASSOC)) {
        echo "<h1>{$film['titre']}</h1>";
        echo "<p>{$film['resume']}</p>"; // Assuming you have a "resume" attribute in your table
    } else {
        echo "Film introuvable";
    }
} else {
    echo "Aucun ID de film fourni";
}


?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<h1>Récupération des paramètres d'URL</h1>

</body>
</html>