<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of historiqueDB
 *
 * @author marc
 */
class historiqueBD
{
    private $cnx;
    
    public function __construct($db)
    {
        $this->cnx=$db;
    }
    
    function historiqueClient($Identifiant,$mdp) 
    {
        $query="select * from historique where id_client=".$_SESSION['id_client'];

        $result=pg_query($this->cnx,$query);

        return $data;
    }
    
    function enregistrementLocation($id_client,$id_dvd,$nom_client,$titre_film,$date_location,$duree) 
    {
        $datetime = date("Y-m-d");
        
        $query="select insert_historique(:id_client,:id_dvd,:nom_client,:titre_film,:date_location,:duree)";
        $resultset = $this->cnx->prepare($query);
                            
        $resultset -> bindValue(1,$_SESSION['id_client']);
        $resultset -> bindValue(2,$_SESSION['id_dvd']); 
        $resultset -> bindValue(3,$_SESSION['nom']); 
        $resultset -> bindValue(4,$_SESSION['titre']);
        $resultset -> bindValue(5,$datetime);
        $resultset -> bindValue(6,$_POST['choix']); 
                         
        $resultset->execute();
                           
        $retour = $resultset->fetchColumn(0);

        return $retour;
    }
    
    function toutLHistorique() 
    {
        $query="select * from historique";

        $resultset = $this->cnx->prepare($query);

        $resultset->execute();
        $data = $resultset->fetchAll();

        return $data;
    }
    
    function clientHistorique() 
    {
        $query="select * from historique,client where client.id_client=historique.id_client";
        // distinct ne fonctionne pas en postgreSQL
        $resultset = $this->cnx->prepare($query);

        $resultset->execute();
        $data = $resultset->fetchAll();

        return $data;
    }
    
    function deleteHistorique($id_client,$id_dvd) 
    {
        $query="select delete_historique(:id_client,:id_dvd)";
        $resultset = $this->cnx->prepare($query);

        $resultset -> bindValue(1,$_POST['client']);
        $resultset -> bindValue(2,$_POST['film']); 
                        
        $resultset->execute();

        $retour = $resultset->fetchColumn(0);

        return $retour;
    }
    
    function historiqueDVDClient($id_dvd,$id_client) 
    {
        $query="select * from historique where id_dvd=".$_POST['film']." and id_client=".$_POST['client'];

        $resultset = $this->cnx->prepare($query);

        $resultset->execute();
        $data = $resultset->fetchAll();

        return $data;
    }
    
    
}
