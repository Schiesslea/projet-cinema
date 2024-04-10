<?php

require_once '../base.php';
require_once BASE_PATH . '/src/config/db-config.php';

function postCommentaire($titre, $avis, $note, $date, $heure, $id_utilisateur, $id_film) : void
{
$pdo=getConnexion();
// Traiter les données
// Traitement des données (insertion dans une base de données)
$requete = $pdo->prepare(query: "INSERT INTO commentaire (titre_commentaire, avis_commentaire, note_commentaire, date_commentaire, heure_commentaire, id_utilisateur, id_film) VALUES (?, ?, ?, ?, ?, ?, ?)");

$requete->bindParam(1, $titre);
$requete->bindParam(2, $avis);
$requete->bindParam(3, $note);
$requete->bindParam(4, $date);
$requete->bindParam(5, $heure);
$requete->bindParam(6, $id_utilisateur);
$requete->bindParam(7, $id_film);

// 3. Exécution de la requête
$requete->execute();

}

function getCommentaire(): array
{
    $pdo=getConnexion();
    // 2. Préparation de la requête
    $requete = $pdo->prepare( "SELECT * FROM commentaire");

// 3. Exécution de la requête
    $requete->execute();

// 4. Récupération des enregistrements
// Un enregistrement = un tableau associatif
    return $requete->fetchAll(PDO::FETCH_ASSOC);

}
?>