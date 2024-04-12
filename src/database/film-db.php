<?php

require_once '../base.php';
require_once BASE_PATH . '/src/config/db-config.php';

function getFilms(): array
{
    $pdo=getConnexion();
    // 2. Préparation de la requête
    $requete = $pdo->prepare( "SELECT * FROM film");

// 3. Exécution de la requête
    $requete->execute();

// 4. Récupération des enregistrements
// Un enregistrement = un tableau associatif
    return $requete->fetchAll(PDO::FETCH_ASSOC);

}

function getFilmParId(?int $id_film) : array|bool
{
    $pdo=getConnexion();
// 2. Préparation de la requête
    $requete = $pdo->prepare( "SELECT * FROM film WHERE id_film = :id");

// 3. Lier le paramètre
    $requete->bindValue(':id', $id_film);

// 4. Exécution de la requête
    $requete->execute();

    return $requete->fetch(PDO::FETCH_ASSOC);
}

function postFilm($titre, $duree, $resume, $date_sortie, $pays, $image, $id_utilisateur) : void
{
    $pdo=getConnexion();
    // Traiter les données
    // Traitement des données (insertion dans une base de données)
    $requete = $pdo->prepare(query: "INSERT INTO film (titre, duree, resume, date_sortie, pays, image, id_utilisateur) VALUES (?, ?, ?, ?, ?, ?, ?)");

    $requete->bindParam(1, $titre);
    $requete->bindParam(2, $duree);
    $requete->bindParam(3, $resume);
    $requete->bindParam(4, $date_sortie);
    $requete->bindParam(5, $pays);
    $requete->bindParam(6, $image);
    $requete->bindParam(7, $id_utilisateur);

    // 3. Exécution de la requête
    $requete->execute();

}

function getFilmUser(?int $id_utilisateur) : array|bool
{
    $pdo=getConnexion();
// 2. Préparation de la requête
    $requete = $pdo->prepare( "SELECT * FROM film WHERE id_utilisateur = :id");

// 3. Lier le paramètre
    $requete->bindValue(':id', $id_utilisateur);

// 4. Exécution de la requête
    $requete->execute();

    return $requete->fetch(PDO::FETCH_ASSOC);
}

?>