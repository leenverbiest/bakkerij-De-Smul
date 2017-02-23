<?php

/**
 * Created by PhpStorm.
 * User: cyber10
 * Date: 15/02/2017
 * Time: 15:47
 */
class Bestellijn
{
    private static $idMap=array();  //array van array =>samengestelde sleutel bestelnr,lijnnr

    private $bestelnr;
    private $productnr;
    private $bestel_aantal;

    /**
     * Bestellijn constructor.
     * @param $lijnnr
     * @param $bestelnr
     * @param $productnr
     * @param $bestel_aantal
     */
    private function __construct($bestelnr, $productnr, $bestel_aantal)
    {
        $this->bestelnr = $bestelnr;
        $this->productnr = $productnr;
        $this->bestel_aantal = $bestel_aantal;
    }
    public static function create($bestelnr, $productnr, $bestel_aantal)
    {
        if (!isset(self::$idMap[$bestelnr][$productnr])){
            self::$idMap[$bestelnr][$productnr]=new Bestellijn($bestelnr, $productnr, $bestel_aantal);
        }
        return self::$idMap[$bestelnr][$productnr];
    }

    //GETTERS
    public function getBestelnr(){return $this->bestelnr;}
    public function getProductnr(){return $this->productnr;}
    public function getBestelAantal(){return $this->bestel_aantal;}

    //SETTERS
    public function setBestelnr($bestelnr){$this->bestelnr = $bestelnr;}
    public function setProductnr($productnr){$this->productnr = $productnr;}
    public function setBestelAantal($bestel_aantal){$this->bestel_aantal = $bestel_aantal;}





}