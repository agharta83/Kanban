<?php

// Design Pattern : Singleton
class Database {
    /** @var PDO */
    private $dbh;
    private static $_instance;

    private function __construct() {
        try {
            $this->dbh = new PDO(
                "mysql:host=localhost;dbname=okanban;charset=utf8",
                'okanban',
                'okanban',
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING) // Affiche les erreurs SQL à l'écran
            );
        }
        catch(Exception $exception) {
            die('Erreur de connexion...' . $exception->getMessage());
        }
    }

    // the unique method you need to use
    public static function getPDO() {
        // If no instance => create one
        if (empty(self::$_instance)) {
            self::$_instance = new Database();
        }
        return self::$_instance->dbh;
    }
}
