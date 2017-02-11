<?php
/**
 * Created by PhpStorm.
 * User: cyber10
 * Date: 19/01/2017
 * Time: 13:10
 */
//data/KlantDAO.php

namespace data;
include_once ('../entities/Klant.php');
include_once ('DBCONFIG.php');
use entities\Klant;
use DBCONFIG;


class KlantDAO
{
    //READ
    //haal alle klanten uit de database
    //returnt een ARRAY VAN KLANT-OBJECTEN
    public function getAll(){
        $sql="select klantnr,voornaam,naam,straat,postcode,gemeente,email,wachtwoord from klanten";
        $dbh=new \PDO(DBCONFIG::$DB_CONNSTRING,DBCONFIG::$DB_USERNAME,DBCONFIG::$DB_PASSWORD);
        //$dbh=new PDO(DBCONFIG::$DB_CONNSTRING,DBCONFIG::$DB_PASSWORD,DBCONFIG::$DB_USERNAME);
        $resultSet=$dbh->query($sql);
        $lijst=array();
        foreach ($resultSet as $rij){
            $klant=Klant::create($rij["klantnr"],$rij["voornaam"],$rij["naam"],$rij["straat"],
                                 $rij["postcode"],$rij["gemeente"],$rij["email"],$rij["wachtwoord"]);
            array_push($lijst,$klant);
        }
        $dbh=null;
        return $lijst; //ARRAY VAN KLANT-OBJECTEN
    }
    //haal één specifieke klant op
    //returnt één KLANT-OBJECT
    public function getById($id){
        $sql="select voornaam,naam,straat,postcode,gemeente,email,wachtwoord from klanten WHERE klantnr=:id";
        $dbh=new \PDO(DBCONFIG::$DB_CONNSTRING,DBCONFIG::$DB_USERNAME,DBCONFIG::$DB_PASSWORD);
        $stmt=$dbh->prepare($sql);
        $stmt->execute(array(':id'=>$id));
        $rij=$stmt->fetch(\PDO::FETCH_ASSOC);

        $klant=Klant::create($id,$rij["voornaam"],$rij["naam"],$rij["straat"],
        $rij["postcode"],$rij["gemeente"],$rij["email"],$rij["wachtwoord"]);
        $dbh=null;
        return $klant;      //KLANT-OBJECT
    }
         public function getIdByEmail($email){
        /*haalt het klantnr op aan de hand van het emailadres(=gebruikersnaam)
         * returns integer (klantnummer)
         */
        $sql="select klantnr from klanten where email=:email";
        $dbh=new \PDO(DBCONFIG::$DB_CONNSTRING,DBCONFIG::$DB_USERNAME,DBCONFIG::$DB_PASSWORD);
        $stmt=$dbh->prepare($sql);
        $stmt->execute(array(':email'=>$email));
        $rij=$stmt->fetch(\PDO::FETCH_ASSOC);
        return $rij["klantnr"]; //INTEGER
    }

        public function getWachtwoordByEmail($email){
        /*haalt het gehashte wachtwoord op aan de hand van het emailadres
        *returnt VARCHAR (gehashte wachtwoord) of FALSE
        */
        $sql="select wachtwoord from klanten where email=:email";
        $dbh=new \PDO(DBCONFIG::$DB_CONNSTRING,DBCONFIG::$DB_USERNAME,DBCONFIG::$DB_PASSWORD);
        $stmt=$dbh->prepare($sql);
        $stmt->execute(array(':email'=>$email));
        $rij=$stmt->fetch(\PDO::FETCH_ASSOC);
        if ($rij["wachtwoord"]){
            //als email reeds gekend is
            return $rij["wachtwoord"]; //returnt het gehashte wachtwoord
        }else{
            //als email nog niet gekend is
          return false;
            }
        }

    //CREATE
    //voeg record toe aan de tabel klanten
    public function create($voornaam,$naam,$straat,$postcode,$gemeente,$email,$wachtwoord)
    {
        //voegt een nieuwe klant toe aan de database
        //returnt een object $klant met de gegevens van de net toegevoegde klant
        $hashedValue=password_hash($wachtwoord,PASSWORD_DEFAULT);
        $wachtwoord=$hashedValue;
        $sql = "insert into klanten (voornaam,naam,straat,postcode,gemeente,email,wachtwoord)
                VALUES(:voornaam,:naam,:straat,:postcode,:gemeente,:email,:wachtwoord) ";
        $dbh=new \PDO(DBCONFIG::$DB_CONNSTRING,DBCONFIG::$DB_USERNAME,DBCONFIG::$DB_PASSWORD);
        $stmt = $dbh->prepare($sql);
        $stmt->execute(array(
            ':voornaam' => $voornaam,
            ':naam' => $naam,
            ':straat' => $straat,
            ':postcode' => $postcode,
            ':gemeente'=>$gemeente,
            ':email' => $email,
            ':wachtwoord' => $wachtwoord
        ));
        $klantnr = $dbh->lastInsertId();
        $dbh = null;
        $klant=Klant::create($klantnr,$voornaam,$naam,$straat,$postcode,$gemeente,$email,$wachtwoord);
        return $klant;  //RETURN OBJECT KLANT
    }
    //UPDATE
    //Klant met bepaald klantnr updaten
        public function update($klant)
        {
            $sql = "update klanten set voornaam=:voornaam,naam=:naam,straat=:straat,postcode=:postcode,gemeente=:gemeente,
              email=:email
              where klantnr=:id";

            $dbh = new PDO(DBCONFIG::$DB_CONNSTRING, DBCONFIG::$DB_USERNAME, DBCONFIG::$DB_PASSWORD);
            $stmt = $dbh->prepare($sql);
            $stmt->execute(array(
                ':voornaam' =>$klant->getVoornaam(),
                ':naam' => $klant->getNaam(),
                ':straat' => $klant->getStraat(),
                ':postcode' => $klant->getPostcode(),
                ':gemeente'=>$klant->getGemeente(),
                ':email' => $klant->getEmail(),
                ':id' => $klant->getKlantnr()
            ));
            $dbh = null;
        }
    //DELETE
    //Klant met bepaald klantnr verwijderen
    //returnt niets
    public function delete($id){
        $sql="delete from klanten where klantnr=:id";
        $dbh=new PDO(DBCONFIG::$DB_CONNSTRING,DBCONFIG::$DB_USERNAME,DBCONFIG::$DB_PASSWORD);
        $stmt=$dbh->prepare($sql);
        $stmt->execute(array(':id'=>$id));
        $dbh=null;

    }
}