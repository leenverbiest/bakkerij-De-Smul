<?php
/**
 * Created by PhpStorm.
 * User: cyber10
 * Date: 18/01/2017
 * Time: 15:24
 */
//entities/Klant.php

namespace entities;


class Klant
{

    private static $idMap=array();

    private $klantnr;
    private $voornaam;
    private $naam;
    private $straat;
    private $postcode;
    private $gemeente;
    private $email;
    private $wachtwoord;

    /*de constructor function is private zodat er van buiten de klasse Klant
    *geen nieuw Klant-object meer aangemaakt kan worden
     */
    private function __construct($klantnr, $voornaam, $naam, $straat, $postcode,$gemeente, $email, $wachtwoord)
    {
        $this->klantnr = $klantnr;
        $this->voornaam = $voornaam;
        $this->naam = $naam;
        $this->straat = $straat;
        $this->postcode = $postcode;
        $this->gemeente=$gemeente;
        $this->email = $email;
        $this->wachtwoord = $wachtwoord;
    }
    //de aanmaak van een nieuw Klantobject gebeurt door de create functie
    //die eerst controleert of er nog geen Klantobject met dat klantnr bestaat
    public static function create($klantnr,$voornaam,$naam,$straat,$postcode,$gemeente,$email,$wachtwoord){
        if(!isset(self::$idMap[$klantnr])){
            self::$idMap[$klantnr]=new Klant($klantnr,$voornaam,$naam,$straat,$postcode,$gemeente,$email,$wachtwoord);
        }
        return self::$idMap[$klantnr];
    }

    //GETTERS
    public function getKlantnr(){return $this->klantnr;}
    public function getVoornaam(){return $this->voornaam;}
    public function getNaam(){return $this->naam;}
    public function getStraat(){return $this->straat;}
    public function getPostcode(){return $this->postcode;}
    public function getGemeente(){return $this->gemeente;}
    public function getEmail(){return $this->email;}
    public function getWachtwoord(){return $this->wachtwoord;}

    //SETTERS (geen voor klantnr want deze is auto_increment
    public function setVoornaam($voornaam){$this->voornaam = $voornaam;}
    public function setNaam($naam){$this->naam = $naam;}
    public function setStraat($straat){$this->straat = $straat;}
    public function setPostcode($postcode){$this->postcode= $postcode;}
    public function setGemeente($gemeente){$this->gemeente=$gemeente;}
    public function setEmail($email){$this->email = $email;}
    public function setWachtwoord($wachtwoord){$this->wachtwoord = $wachtwoord;}





}