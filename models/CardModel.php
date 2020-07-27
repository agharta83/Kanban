<?php

class CardModel {

  public $id;
  public $title;
  public $ordering;
  public $list_id;

  public function create( $data ) {

      $listId = $data['list_id'];
      $text = $data['title'];

      // On crée la requête SQL
      $sql = "INSERT INTO cards (id, title, ordering, list_id) VALUES (NULL, \"$text\", 0, $listId)";

      // On récupère la connexion à la BDD
      $conn = Database::getPDO();

      // On exécute la requpete
      $stmt = $conn->query( $sql );
  }

  // Met à jour le contenu d'une carte
  public function update( $id, $title ) {

      // On construit la requête SQL
      $sql = "UPDATE cards SET title = \"$title\" WHERE id = $id";

      // On récupère la connexion à la BDD
      $conn = Database::getPDO();

      // On exécute la requpete
      $conn->query( $sql );
  }
}
