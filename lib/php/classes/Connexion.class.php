<?php
//singleton : à tout moment , un seul objet ne peut exister
class Connexion {

    private static $_instance = null;

    public static function getInstance($dsn, $user, $password) {
        // :: = appel à une var ou fct statique  
        //self:: référence la classe, tandis que $this référence l'objet instancié
        //ici, obligation d'utiliser self car classe statique sans instanciation
        if (!self::$_instance) {
            try {
                self::$_instance = new PDO($dsn, $user, $password);
                //spécifie la manière dont PDO rapportera les erreurs : on demande ici une exception 
                //(plutôt qu'un warning PDO::ERRMODE_WARNING)
                self::$_instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                //print "Connect&eacute;";
                
            } catch (PDOException $e) {
                print "Erreur de connexion : ".$e->getMessage()." ".$e->getLine();
                //print "pass : ".$pass. " user = ".$user;
            }
        }
        return self::$_instance;
    }
}
