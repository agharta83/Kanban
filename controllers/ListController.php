<?php

class ListController extends CoreController {
    
    public function list($params) {
        // Je récupère l'id de l'URL
        $currentListId = $params['id'];

        // Je récupére l'objet ListModel correspondant à l'id
        $model = new ListModel();
        $currentListModel = $model->read($currentListId);

        // Appel la méthode s'occupant de la partie views
        $this->show('list', [
            'listId' => $currentListModel->id,
            'listName' => $currentListModel->name
        ]);
    }

    // Modifie le titre d'une liste
    public function update( $params ) {

        // On modifie le titre de la liste
        $model = new ListModel();
        $model->update( $params['id'], $_POST['title'] );

        // On répond au navigateur
        echo json_encode([
            'action' => 'ok',
            'title' => $_POST['title']
        ]);
    }

    // Crée une nouvelle carte
    public function createCard() {

        // On récupère les données
        $id = $_POST['id'];
        $title = $_POST['title'];

        // On appel le model "CardModel"
        // pour créer une nouvelle carte
        $model = new CardModel();
        $model->create([
            'list_id' => $id,
            'title' => $title
        ]);

        echo json_encode([
            'action' => 'ok'
        ]);
    }

    // Met à jour la contenu d'une carte
    public function cardUpdate( $params ) {

        // On récupère nos données
        $title = $_POST['title'];
        $cardId = $params['id'];

        // On fait la mise à jour en BDD
        $model = new CardModel();
        $model->update($cardId, $title);

        // On envoie la réponse
        echo json_encode([ 'action' => 'ok' ]);
    }

    public function positions() {

        $model = new ListModel();

        // On parcours les listes mises à jour
        foreach($_POST['cards'] as $listId => $cards) {

            foreach($cards as $cardId => $pos) {

                // On met à jour la position d'une carte de la liste
                $model->setPosition($cardId, $pos, $listId);
            }
        }
    }
}
