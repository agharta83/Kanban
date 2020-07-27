<?php

class CoreController {

    // Méthode permettant de factoriser le code appelant les views
    protected function show($viewName, $viewVars=array()) {
        // $viewVars est disponible dans chaque fichier de vue
        // Inclusion des views
        include(__DIR__.'/../views/header.php');
        include(__DIR__.'/../views/'.$viewName.'.php');
        include(__DIR__.'/../views/footer.php');
    }
}
