<?php

class MainController extends CoreController {

    // Méthode gérant la home
    public function home() {

        // On récupère toutes les listes de la BDD
        $model = new ListModel();
        $results = $model->findAll();

        // Appel la méthode s'occupant de la partie views
        $this->show('home', $results);
    }

    // Méthode gérant la page de contact
    public function contact() {
        // Appel la méthode s'occupant de la partie views
        $this->show('contact');
    }

    public function test() {

        // On créer une requête SQL pour récupérer
        // la liste numéro 1
        $model = new ListModel();
        $list = $model->findAll();

        // On affiche le nom de la liste
        echo json_encode($list);
    }
}
