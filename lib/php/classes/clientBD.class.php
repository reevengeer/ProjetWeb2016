<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clientDB
 *
 * @author marc
 */
class clientBD
{
    private $cnx;
    
    public function __construct($db)
    {
        $this->cnx=$db;
    }
    
    function connexionClient($Identifiant,$mdp) 
    {
        $query = "select * from client where login='".$_POST["Identifiant"]."' AND password='".$_POST["mdp"]."'";

        $resultset = $this->cnx->prepare($query);

        $resultset->execute();
        $data = $resultset->fetchAll();
                       
        return $data;
    }
    
    function inscription($nom,$prenom,$ville,$adresse,$Identifiant,$mdp) 
    {
        $query="select insert_client(:nom,:prenom,:ville,:adresse,:login,:password)";
        
        $resultset = $this->cnx->prepare($query);

        $resultset -> bindValue(1,$_POST['nom']); 
        $resultset -> bindValue(2,$_POST['prenom']); 
        $resultset -> bindValue(3,$_POST['ville']);
        $resultset -> bindValue(4,$_POST['adresse']);
        $resultset -> bindValue(5,$_POST['Identifiant']); 
        $resultset -> bindValue(6,$_POST['mdp']);

        $resultset->execute();

        $retour = $resultset->fetchColumn(0);
        
        return $retour;
    }

    function retrouverMDPClient($Identifiant,$nom,$prenom,$ville) 
    {
        $query = "select * from client where login='".$_POST["Identifiant"]."' AND NOM='".$_POST["nom"]."' AND PRENOM='".$_POST["prenom"]."' AND VILLE='".$_POST["ville"]."'";

        $resultset = $this->cnx->prepare($query);

        $resultset->execute();
        $data = $resultset->fetchAll();
                       
        return $data;
    }
    
    function modifierClient($nom,$prenom,$ville,$adresse,$login,$password) 
    {
        $query="select update_client(:nom,:prenom,:ville,:adresse,:login,:password)";
        $resultset = $this->cnx->prepare($query);

        $resultset -> bindValue(1,$_SESSION['nom']);
        $resultset -> bindValue(2,$_SESSION['prenom']); 
        $resultset -> bindValue(3,$_POST['ville']); 
        $resultset -> bindValue(4,$_POST['adresse']);
        $resultset -> bindValue(5,$_POST['login']);
        $resultset -> bindValue(6,$_POST['password']); 

        $resultset->execute();

        $retour = $resultset->fetchColumn(0);
                       
        return $retour;
    }
    
    function rechercheClientSurSonID($id_client) 
    {
        $query="select * from client where id_client=".$_SESSION['id_client'];

        $resultset = $this->cnx->prepare($query);

        $resultset->execute();
        $data = $resultset->fetchAll();
                       
        return $data;
    }
    
    function updateReduction($id_client) 
    {
        $query="select update_reduction(:id_client)";
        $resultset = $this->cnx->prepare($query);

        $resultset -> bindValue(1,$_SESSION['id_client']);

        $resultset->execute();

        $retour = $resultset->fetchColumn(0);
                       
        return $retour;
    }
}