<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of JsonBD
 *
 * @author marc
 */
class JsonBD 
{
    private $_db;
    private $_clientArray = array();

    public function __construct($cnx)
    {
        $this->_db = $cnx;
    }

    public function getClient($login) 
    {
        $query = "select password from client where login=:login";
        try
        {
            $resultset = $this->_db->prepare($query);
            $resultset->bindValue(1,trim($login), PDO::PARAM_STR);
            $resultset->execute();
        }
        catch (PDOException $e) 
        {
            print $e->getMessage();
        }

        while ($data = $resultset->fetch()) 
        {
            try
            {
                $_clientArray[] = $data;
                return $_clientArray;
            } 
            catch (PDOException $e) 
            {
                print $e->getMessage();
            }
        }
        
    }
    
    public function getAdministrateur($login) 
    {
        $query = "select password from administrateur where login=:login";
        try
        {
            $resultset = $this->_db->prepare($query);
            $resultset->bindValue(1,trim($login), PDO::PARAM_STR);
            $resultset->execute();
        }
        catch (PDOException $e) 
        {
            print $e->getMessage();
        }

        while ($data = $resultset->fetch()) 
        {
            try
            {
                $_clientArray[] = $data;
                return $_clientArray;
            } 
            catch (PDOException $e) 
            {
                print $e->getMessage();
            }
        }
    }
}
