<?php
header('Content-Type: application/json');
require '../dbConnectProjetLocal.php';
require '../classes/Connexion.class.php';
require '../classes/JsonBD.class.php';

$cnx = Connexion::getInstance($dsn,$user,$password);

try
{  
    $search = new JsonBD($cnx);
    $retour = $search->getClient(trim($_GET['login']));    
    if($retour=="")
    {
        $retour2 = $search->getAdministrateur(trim($_GET['login']));
        print json_encode($retour2);
    }
    else
        print json_encode($retour);
}
catch(PDOException $e){}