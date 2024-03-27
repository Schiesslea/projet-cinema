<?php

require_once '../base.php';
require_once BASE_PROJET . '/src/database/user-db.php';

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
    if (empty($mdp_utilisateur)) {
        $erreurs['mdp_utilisateur'] = "Le mot de passe est obligatoire";
    }
}


    $email_user = getUser($email_utilisateur);
    $mdp = getMdp($email_utilisateur);
    if ($email_user) {
        foreach ($email_user as $info_user) {
            foreach ($mdp as $mdp_user) {
                if (password_verify($mdp_utilisateur, $mdp_user)) {
                    session_start();
                    $_SESSION["utilisateur"] = [
                        "pseudo_utilisateur"=>$info_user["pseudo_utilisateur"]
                    ];
                    header("Location: ../index.php");
                    exit();
                } else {
                    $erreurs['email_utilisateur'] = "identifiants incorrects";
                    $erreurs['mdp_utilisateur'] = "identifiants incorrects";
                }
            }
        }

        } else {
            $erreurs['email_utilisateur'] = "identifiants incorrects";
            $erreurs['mdp_utilisateur'] = "identifiants incorrects";
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

    <title>Connexion à un compte</title>
    <link rel="shortcut icon" href="/public/assets/images/film.svg">

</head>
<body class="bg-dark">
<!--Insertion d'un menu-->
<?php require_once "../base.php";
require_once BASE_PROJET . '/src/_partials/menu.php';
?>
<div class="container">
<h1 class="mt-4" style="border-bottom: solid; border-bottom-color: #86C232; color: #86C232">Connexion</h1>
</div>
<!-- Création d'un compte -->
<div class="container d-flex">
    <div class="w-50 mx-auto shadow my-5 p-4 rounded" style="background-color: #86C232">
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


<script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>