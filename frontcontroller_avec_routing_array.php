<?php

// Inclusion des classes nécessaires
require(__DIR__.'/controllers/MainController.php');
require(__DIR__.'/inc/Database.php');

// Array de Routes
// (pattern URL en clé => ControllerName#MethodName en valeur)
$routesList = [
  // Page d'accuei
  '/' => 'MainController#home',
  // Toutes les listes
  '/lists' => 'ListController#lists',
  // Page de contact
  '/contact' => 'MainController#contact',
];

// Je récupère le pattern d'URL courant
// Condition ternaire : a ? b : c
// => si a est vrai, alors on prend b, si faux, on prend c
$patternURL = isset($_GET['_url']) ? $_GET['_url'] : '/'; // equivalent à $currentURL dans coffee shop

// On check chaque route pour savoir si elle correspond au pattern d'URL courant
if (array_key_exists($patternURL, $routesList)) {
    // On récupère la string 'Controller#Method'
    $matchingValue = $routesList[$patternURL];
    
    // J'extraie le nom du controller et le nom de la méthode
    $infos = explode('#', $matchingValue);
    $controllerName = $infos[0];
    $methodName = $infos[1];
    
    // Alors, on instancie le controller (son nom est dynamique)
    $controller = new $controllerName();
    // Puis on appelle la méthode du controller (son nom est dynamique)
    $controller->$methodName();
}
// Si on ne trouve pas de route correspondante
else {
    // TODO faire une vraie belle page 404
    echo '404';
}
