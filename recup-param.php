<?php
// Récupère le paramètre d'URL 'prenom'
// Tester la présence du paramètre
$resume = $_GET["resume"];

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
    <p><?= $resume ?></p>

</body>
</html>