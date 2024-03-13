<?php

/**
 * @var PDO $pdo
 */
require './config/db-config.php';


// Déterminer si le formulaire a été soumis
// Utilisation d'une variable superglobale $_SERVER
// $_SERVER : tableau associatif contenant des informations sur la requête HTTP
$erreurs = [];
$email_utilisateur = "";
$mdp_utilisateur = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Le formulaire a été soumis !
    // Traiter les données du formulaire
    // Récupérer les valeurs saisies par l'utilisateur
    // Superglobale $_POST : tableau associatif
    $email_utilisateur = $_POST['email_utilisateur'];
    $mdp_utilisateur = $_POST['mdp_utilisateur'];
    //Validation des données
    if (empty($email_utilisateur)) {
        $erreurs['email_utilisateur'] = "L'email est obligatoire";
    } elseif (!filter_var($email_utilisateur, FILTER_VALIDATE_EMAIL)) {
        $erreurs['email_utilisateur'] = "L'email n'est pas valide";
    }
    if (empty($mdp_utilisateur)) {
        $erreurs['mdp_utilisateur'] = "Le mot de passe est obligatoire";
    }






        // Traiter les données
        if (empty($erreurs)) {
            // Traitement des données (insertion dans une base de données)
            $requete = $pdo->prepare(query: "INSERT INTO utilisateur (pseudo_utilisateur, email_utilisateur, mdp_utilisateur) VALUES (?, ?, ?)");

            $requete->bindParam(1, $pseudo_utilisateur);
            $requete->bindParam(2, $email_utilisateur);
            $requete->bindParam(3, password_hash($mdp_utilisateur, PASSWORD_DEFAULT));

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
    <title>Création d'un compte</title>
</head>
<body class="">
<!--Insertion d'un menu-->
<?php include_once './_partials/menu.php' ?>
<h1 class="text-center text-black">Création d'un compte</h1>

<!-- Création d'un compte -->
<div class="container d-flex">
    <div class="w-50 mx-auto shadow my-5 p-4 rounded" style="background-color: #00ABE4">
        <form action="" method="post" novalidate>
            <div class="mb-3">
                <label for="email_utilisateur" class="form-label">Email*</label>
                <input type="email"
                       class="form-control <?= (isset($erreurs['email_utilisateur'])) ? "border border-2 border-danger" : "" ?>"
                       id="email_utilisateur"
                       name="email_utilisateur" value="<?= ($erreurs) ? "" : $email_utilisateur ?>" placeholder="Saisir votre email"
                       aria-describedby="emailHelp">
                <?php if (isset($erreurs['email_utilisateur'])) : ?>
                    <p class="form-text text-danger"><?= $erreurs['email_utilisateur'] ?></p>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="mdp_utilisateur" class="form-label">Mot de passe*</label>
                <input type="password"
                       class="form-control <?= (isset($erreurs['mdp_utilisateur'])) ? "border border-2 border-danger" : "" ?>"
                       id="mdp_utilisateur" name="mdp_utilisateur" value="<?= (!empty($erreurs)) ? $mdp_utilisateur :   ""  ?>" placeholder="Saisir votre mot de passe"
                       aria-describedby="emailHelp">
                <?php if (isset($erreurs['mdp_utilisateur'])) : ?>
                    <p class="form-text text-danger"><?= $erreurs['mdp_utilisateur'] ?></p>
                <?php endif; ?>
            </div>
            <p>* Champs obligatoires</p>
            <div class="text-center">
                <button type="submit" class="btn btn-light ">Valider</button>
            </div>
            <p class="mt-3">Vous ne possédez pas de compte ? <a href="/creation-compte.php" class="text-dark">inscrivez-vous</a></p>
        </form>
    </div>
</div>
</div>


<script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>