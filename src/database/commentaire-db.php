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

function getCommentaire($id_film): array
{
    $pdo=getConnexion();
    // 2. Préparation de la requête
    $requete = $pdo->prepare( "SELECT * FROM commentaire WHERE id_film=$id_film ORDER BY date_commentaire DESC, heure_commentaire DESC");

// 3. Exécution de la requête
    $requete->execute();

// 4. Récupération des enregistrements
// Un enregistrement = un tableau associatif
    return $requete->fetchAll(PDO::FETCH_ASSOC);

}

function getMoyenneNoteEtCommentaire($id_film) : array
{
    $pdo=getConnexion();
    $requete = $pdo->prepare( "SELECT ROUND(AVG(note_commentaire), 1) AS 'moyenne_note', COUNT(note_commentaire) AS 'nombre_commentaire' FROM commentaire WHERE id_film=$id_film");
    $requete->execute();
    return $requete->fetchAll(PDO::FETCH_ASSOC);

}
?>