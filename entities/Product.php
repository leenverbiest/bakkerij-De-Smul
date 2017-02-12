<?php

/**
 * Created by PhpStorm.
 * User: Leen
 * Date: 12/02/2017
 * Time: 20:11
 */
class Product
{
    private static $idMap=array();
    private $productnr;
    private $catnr;
    private $productnaam;
    private $eenheidsprijs;
    /*de constructor function is private zodat er van buiten de klasse Product
     *geen nieuw Product-object meer aangemaakt kan worden
     */
    private function __construct($productnr,$catnr,$productnaam, $eenheidsprijs)
    {
        $this->productnr = $productnr;
        $this->catnr=$catnr;
        $this->productnaam = $productnaam;
        $this->eenheidsprijs = $eenheidsprijs;
    }
    public function create($productnr,$catnr,$productnaam, $eenheidsprijs){
        if(!isset(self::$idMap[$productnr])){
            self::$idMap[$productnr]=new Product($productnr,$catnr,$productnaam, $eenheidsprijs);
        }
        return self::$idMap[$productnr];
    }
    //GETTERS
    public function getProductnr(){return $this->productnr;}
    public function getCatnr(){return $this->catnr;}
    public function getProductnaam(){return $this->productnaam;}
    public function getEenheidsprijs(){return $this->eenheidsprijs;}
    //SETTERS
    public function setCatnr($catnr){$this->catnr=$catnr;}
    public function setProductnaam($productnaam){$this->productnaam = $productnaam;}
    public function setEenheidsprijs($eenheidsprijs){$this->eenheidsprijs = $eenheidsprijs;}

}