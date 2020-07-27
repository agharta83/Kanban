<?php

// 1 classe correspondant au modèle pour la table lists
// M de MVC = Model
// 1 table = 1 Model = 1 Classe

class ListModel {
    // 1 champ/colonne => 1 propriété publique
    public $id;
    public $name;

    public function create() {

    }

    public function read($id) {
        $sql = "
            SELECT *
            FROM lists
            WHERE id = {$id}
        ";
        // Database::getPDO() est une méthode statique de la classe Database fournie dans "inc/Database.php"
        $pdoStatement = Database::getPDO()->query($sql);
        // Définie la classe que je veux comme résultat
        $pdoStatement->setFetchMode(PDO::FETCH_CLASS, 'ListModel');
        // Retourne tous les résultats sous forme d'array d'objets ListModel
        return $pdoStatement->fetch(PDO::FETCH_CLASS);
    }

    // Retourne toutes les listes
    public function findAll() {

        $sql = "
            SELECT *
            FROM lists
        ";
        // Database::getPDO() est une méthode statique de la classe Database fournie dans "inc/Database.php"
        $pdoStatement = Database::getPDO()->query($sql);

        // Retourne tous les résultats sous forme d'array d'objets ListModel
        return $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'ListModel');
    }

    // Retourne toutes les cartes de la liste
    public function getCards() {

        // On construit la requête SQL
        $sql = "SELECT * FROM cards WHERE list_id=" . $this->id . " ORDER BY ordering ASC";

        // On récupère la connexion à la BDD
        $conn = Database::getPDO();

        // On exécute la requête
        $stmt = $conn->query( $sql );

        // On récupère les résultats de la requête
        return $stmt->fetchAll( PDO::FETCH_CLASS, 'CardModel' );
    }

    // Permet de modifier le titre d'une liste
    public function update( $id, $title ) {

        // On crée la requête SQL
        $sql = "UPDATE lists SET name = \"$title\" WHERE id = $id";

        // On récupère la connexion à la BDD
        $conn = Database::getPDO();

        // On exécute la requête
        $stmt = $conn->query( $sql );

        // On retourne le nombre d'enregistrements
        // qui ont bien été modifiés par la requête
        // EDIT : ha ben non, c'est pas possible
        // return $stmt->fetch();
    }

    // Met à jour la positions des cartes d'une liste
    public function setPosition($cardId, $pos, $listId) {

        // On construit la requête
        $sql = "UPDATE cards SET ordering = $pos, list_id = $listId WHERE id = $cardId";

        // On récupère la connexion à la BDD
        $conn = Database::getPDO();

        // On exécute la requête
        $conn->query( $sql );
    }

    public function delete() {

    }
}
