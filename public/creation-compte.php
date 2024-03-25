<?php

require_once '../base.php';
require_once BASE_PROJET . '/src/database/user-db.php';


// Déterminer si le formulaire a été soumis
// Utilisation d'une variable superglobale $_SERVER
// $_SERVER : tableau associatif contenant des informations sur la requête HTTP
$erreurs = [];
$pseudo_utilisateur = "";
$email_utilisateur = "";
$mdp_utilisateur = "";
$confirm_mdp_utilisateur = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Le formulaire a été soumis !
    // Traiter les données du formulaire
    // Récupérer les valeurs saisies par l'utilisateur
    // Superglobale $_POST : tableau associatif
    $pseudo_utilisateur = $_POST['pseudo_utilisateur'];
    $email_utilisateur = $_POST['email_utilisateur'];
    $mdp_utilisateur = $_POST['mdp_utilisateur'];
    $confirm_mdp_utilisateur = $_POST['confirm_mdp_utilisateur'];
    //Validation des données
    if (empty($pseudo_utilisateur)) {
        $erreurs['pseudo_utilisateur'] = "Le pseudo est obligatoire";
    }
    if (empty($email_utilisateur)) {
        $erreurs['email_utilisateur'] = "L'email est obligatoire";
    } elseif (!filter_var($email_utilisateur, FILTER_VALIDATE_EMAIL)) {
        $erreurs['email_utilisateur'] = "L'email n'est pas valide";
    }
    if (empty($mdp_utilisateur)) {
        $erreurs['mdp_utilisateur'] = "Le mot de passe est obligatoire";
    }
    if (empty($confirm_mdp_utilisateur)) {
        $erreurs['confirm_mdp_utilisateur'] = "La confirmation du mot de passe est obligatoire";
    }
    if ($mdp_utilisateur != $confirm_mdp_utilisateur) {
        $erreurs['mdp_utilisateur'] = "Vous devez mettre le même mot de passe";
        $erreurs['confirm_mdp_utilisateur'] = "Vous devez mettre le même mot de passe";
    }
    if (strlen($mdp_utilisateur)>14 || strlen($mdp_utilisateur)<8) {
        $erreurs['mdp_utilisateur'] = "Votre mot de passe doit contenir entre 8 et 14 caractères";
    }
    if (!preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W)#', $mdp_utilisateur)) {
        $erreurs['mdp_utilisateur'] = "Votre mot de passe doit contenir un chiffre, une minuscule, un caractère spécial et une majuscule";
    }
    else {



    getUser($email_utilisateur);
    if (getUser($email_utilisateur)) {
        $erreurs['email_utilisateur'] = "L'email est déjà associé à un compte";
    } else {
        // email n'existe pas


    // Traiter les données
    if (empty($erreurs)) {
        postUser($pseudo_utilisateur, $email_utilisateur, $mdp_utilisateur);

        // Rediriger l'utilisateur vers une autre page du site
        header("Location: /index.php");
        exit();
    }
}
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

    <title>Création d'un compte</title>
    <link rel="shortcut icon" href="/public/assets/images/film.svg">

</head>
<body class="bg-dark">
<!--Insertion d'un menu-->
<?php require_once "../base.php";
require_once BASE_PROJET . '/src/_partials/menu.php';
?>
<div class="container">
<h1 class="mt-4 " style="color: #86C232; border-bottom: solid; border-bottom-color: #86C232">Création d'un compte</h1>
</div>
<!-- Création d'un compte -->
<div class="container d-flex">
    <div class="w-50 mx-auto shadow  my-5 p-4 rounded" style="background-color: #86C232" >
        <form action="" method="post" novalidate>
            <div class="mb-3">
                <label for="pseudo_utilisateur" class="form-label">Pseudo*</label>
                <input type="text"
                       class="form-control <?= (isset($erreurs['pseudo_utilisateur'])) ? "border border-2 border-danger" : "" ?>"
                       id="pseudo_utilisateur" name="pseudo_utilisateur" value="<?= $pseudo_utilisateur ?>" placeholder="Saisir votre pseudo"
                       aria-describedby="emailHelp">
                <?php if (isset($erreurs['pseudo_utilisateur'])) : ?>
                    <p class="form-text text-danger"><?= $erreurs['pseudo_utilisateur'] ?></p>
                <?php endif; ?>
            </div>
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
                <label for="mdp_utilisateur" class="form-label">Mot de passe* <button type="button" class="btn   " data-bs-toggle="modal"
                                                                                      data-bs-target="#exampleModal">
                        <i class="bi bi-info-circle" ></i>
                    </button>


                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                         aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Les caractéristiques de votre mot de passe </h1>
                                    <button type="button" class="btn-close " data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <ul>
                                        <li>
                                            Votre mot de passe doit contenir entre 8 et 14 caractères
                                        </li>
                                        <li>
                                            Il doit contenir au moins une minuscule, une majuscule, un caractère spécial et un chiffre
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                     </label>
                <input type="password"
                       class="form-control <?= (isset($erreurs['mdp_utilisateur'])) ? "border border-2 border-danger" : "" ?>"
                       id="mdp_utilisateur" name="mdp_utilisateur" value="<?= (!empty($erreurs)) ? $mdp_utilisateur :   ""  ?>" placeholder="Saisir votre mot de passe"
                       aria-describedby="emailHelp">
                <?php if (isset($erreurs['mdp_utilisateur'])) : ?>
                    <p class="form-text text-danger"><?= $erreurs['mdp_utilisateur'] ?></p>
                <?php endif; ?>
                <p></p>
            </div>
            <div class="mb-3">
                <label for="confirm_mdp_utilisateur" class="form-label">Confirmer votre mot de passe*</label>
                <input type="password"
                       class="form-control  <?= (isset($erreurs['confirm_mdp_utilisateur'])) ? "border border-2 border-danger" : "" ?>"
                       id="confirm_mdp_utilisateur" name="confirm_mdp_utilisateur" value="<?= $confirm_mdp_utilisateur ?>"
                       placeholder="Saisir à nouveau votre mot de passe"
                       aria-describedby="emailHelp">
                <?php if (isset($erreurs['confirm_mdp_utilisateur'])) : ?>
                    <p class="form-text text-danger"><?= $erreurs['confirm_mdp_utilisateur'] ?></p>
                <?php endif; ?>
            </div>
            <p>* Champs obligatoires</p>
            <div class="text-center">
            <button type="submit" class="btn btn-light ">Valider</button>
    </div>
            <p class="mt-3">Vous possédez déjà un compte ? <a href="/connexion.php" class="text-dark">connectez-vous</a></p>
        </form>
    </div>
</div>
</div>


<script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>