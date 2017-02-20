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

    private $lijnnr;
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
    private function __construct($lijnnr, $bestelnr, $productnr, $bestel_aantal)
    {
        $this->lijnnr = $lijnnr;
        $this->bestelnr = $bestelnr;
        $this->productnr = $productnr;
        $this->bestel_aantal = $bestel_aantal;
    }
    public static function create($lijnnr, $bestelnr, $productnr, $bestel_aantal)
    {
        if (!isset(self::$idMap[$bestelnr][$lijnnr])){
            self::$idMap[$bestelnr][$lijnnr]=new Bestellijn($lijnnr, $bestelnr, $productnr, $bestel_aantal);
        }
        return self::$idMap[$bestelnr][$lijnnr];
    }

    //GETTERS
    public function getLijnnr(){return $this->lijnnr;}
    public function getBestelnr(){return $this->bestelnr;}
    public function getProductnr(){return $this->productnr;}
    public function getBestelAantal(){return $this->bestel_aantal;}

    //SETTERS
    public function setLijnnr($lijnnr){$this->lijnnr = $lijnnr;}
    public function setBestelnr($bestelnr){$this->bestelnr = $bestelnr;}
    public function setProductnr($productnr){$this->productnr = $productnr;}





}