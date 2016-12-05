<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of administrateurDB
 *
 * @author marc
 */
class administrateurBD 
{
    private $cnx;
    
    public function __construct($db)
    {
        $this->cnx=$db;
    }
    
    function connexionAdministrateur($Identifiant,$mdp) 
    {
        $query = "select * from Administrateur where login='".$_POST["Identifiant"]."' AND password='".$_POST["mdp"]."'";

        $resultset = $this->cnx->prepare($query);

        $resultset->execute();
        $data = $resultset->fetchAll();
                        
        return $data;
    }

    function retrouverMDPAdministrateur($Identifiant,$nom,$prenom,$ville) 
    {
        $query = "select * from Administrateur where login='".$_POST["Identifiant"]."' AND NOM='".$_POST["nom"]."' AND PRENOM='".$_POST["prenom"]."' AND VILLE='".$_POST["ville"]."'";

        $resultset = $this->cnx->prepare($query);

        $resultset->execute();
        $data = $resultset->fetchAll();
                                               
        return $data;
    }
}
