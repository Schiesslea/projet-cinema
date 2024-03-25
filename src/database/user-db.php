<?php

require_once '../base.php';
require_once BASE_PATH . '/src/config/db-config.php';

function getUser($email_utilisateur): array
{
    $pdo=getConnexion();
    $requete_email = $pdo->prepare("SELECT * FROM utilisateur WHERE email_utilisateur=?");
    $requete_email->execute([$email_utilisateur]);
    $user = $requete_email->fetchAll(PDO::FETCH_ASSOC);
    return $user;
}

function postUser($pseudo_utilisateur, $email_utilisateur, $mdp_utilisateur): void
{
    $pdo=getConnexion();
    $requete = $pdo->prepare(query: "INSERT INTO utilisateur (pseudo_utilisateur, email_utilisateur, mdp_utilisateur) VALUES (?, ?, ?)");

    $requete->bindParam(1, $pseudo_utilisateur);
    $requete->bindParam(2, $email_utilisateur);
    $requete->bindParam(3, password_hash($mdp_utilisateur, PASSWORD_DEFAULT));

    // 3. Exécution de la requête
    $requete->execute();
}
?>