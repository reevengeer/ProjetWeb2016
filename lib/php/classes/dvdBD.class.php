<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of dvdDB
 *
 * @author marc
 */
class dvdBD
{
    private $cnx;
    
    public function __construct($db)
    {
        $this->cnx=$db;
    }
    
    function informationsDVDDEpuisSonID($DvdChoisi) 
    {
        $query="select * from dvd where id_dvd=".$DvdChoisi;

        $resultset = $this->cnx->prepare($query);

        $resultset->execute();
        $data = $resultset->fetchAll();
                       
        return $data;
    }
    
    function updateDVD($id_dvd,$titre,$realisateur,$scenariste,$producteur,$date_sortie,$quantite,$image_dvd,$description) 
    {
        $query2="select update_dvd(:id_dvd,:titre,:realisateur,:scenariste,:producteur,:date_sortie,:quantite,:image_dvd,:description)";
                                        
        $resultset2 = $this->cnx->prepare($query2);

        $resultset2 -> bindValue(1,$_SESSION['id_dvd']);
        $resultset2 -> bindValue(2,$_SESSION['titre']); 
        $resultset2 -> bindValue(3,$_SESSION['realisateur']); 
        $resultset2 -> bindValue(4,$_SESSION['scenariste']);
        $resultset2 -> bindValue(5,$_SESSION['producteur']);
        $resultset2 -> bindValue(6,$_SESSION['date_sortie']); 
        $resultset2 -> bindValue(7,$_SESSION['quantite']);
        $resultset2 -> bindValue(8,$_SESSION['image_dvd']);
        $resultset2 -> bindValue(9,$_SESSION['description']);
                                        
        $resultset2->execute();

        $retour2 = $resultset2->fetchColumn(0);
                       
        return $retour2;
    }
    
    function DVDAvecQuantiteSuperieurAZero() 
    {
        $query="select * from dvd where quantite>0";

        $resultset = $this->cnx->prepare($query);

        $resultset->execute();
        $data = $resultset->fetchAll();
                       
        return $data;
    }
    
    function ajoutDVD($id_administrateur,$titre,$realisateur,$scenariste,$producteur,$date_sortie,$quantite,$image_dvd,$description) 
    {
        $query="select insert_dvd(:id_administrateur,:titre,:realisateur,:scenariste,:producteur,:date_sortie,:quantite,:image_dvd,:description)";
        $resultset = $this->cnx->prepare($query);

        $resultset -> bindValue(1,$_SESSION['id_administrateur']);
        $resultset -> bindValue(2,$_POST['titre']); 
        $resultset -> bindValue(3,$_POST['realisateur']); 
        $resultset -> bindValue(4,$_POST['scenariste']);
        $resultset -> bindValue(5,$_POST['producteur']);
        $resultset -> bindValue(6,$_POST['date_sortie']); 
        $resultset -> bindValue(7,$_POST['quantite']);
        $resultset -> bindValue(8,$_FILES["image_dvd"]["name"]);
        $resultset -> bindValue(9,$_POST['description']);

        $resultset->execute();

        $retour = $resultset->fetchColumn(0);

        return $retour;
    }
    
    function modifierDVD($id_dvd,$titre,$realisateur,$scenariste,$producteur,$date_sortie,$quantite,$image_dvd,$description) 
    {
        $query="select update_dvd(:id_dvd,:titre,:realisateur,:scenariste,:producteur,:date_sortie,:quantite,:image_dvd,:description)";
        $resultset = $this->cnx->prepare($query);

        $resultset -> bindValue(1,$_SESSION['id_dvd']);
        $resultset -> bindValue(2,$_POST['titre']); 
        $resultset -> bindValue(3,$_POST['realisateur']); 
        $resultset -> bindValue(4,$_POST['scenariste']);
        $resultset -> bindValue(5,$_POST['producteur']);
        $resultset -> bindValue(6,$_POST['date_sortie']); 
        $resultset -> bindValue(7,$_POST['quantite']);
        $resultset -> bindValue(8,$_FILES["image_dvd"]["name"]);
        $resultset -> bindValue(9,$_POST['description']);

        $resultset->execute();

        $retour = $resultset->fetchColumn(0);

        return $retour;
    }
    
    function tousLesDVD() 
    {
        $query="select * from dvd";

        $resultset = $this->cnx->prepare($query);

        $resultset->execute();
        $data = $resultset->fetchAll();

        return $data;
    }
    
    function supprimerDVD($id_dvd) 
    {
        $query="select delete_dvd(:id_dvd)";
        $resultset = $this->cnx->prepare($query);

        $resultset -> bindValue(1,$_SESSION['id_dvd']);

        $resultset->execute();

        $retour = $resultset->fetchColumn(0);
                       
        return $retour;
    }
}
