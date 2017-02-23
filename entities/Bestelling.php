<?php

/**
 * Created by PhpStorm.
 * User: cyber10
 * Date: 15/02/2017
 * Time: 15:47
 */
class Bestelling
{
    private static $idMap=array();

    private $bestelnr;
    private $klantnr;
    private $besteldatum;
    private $bestel_aantal;
    private $afhaaldatum;
    private $status;

    /**
     * Bestelling constructor.
     * @param $bestelnr
     * @param $klantnr
     * @param $besteldatum
     * @param $bestel_aantal
     * @param $afhaaldatum
     * @param $status
     */
    private function __construct($bestelnr, $klantnr, $besteldatum, $bestel_aantal, $afhaaldatum, $status)
    {
        $this->bestelnr = $bestelnr;
        $this->klantnr = $klantnr;
        $this->besteldatum = $besteldatum;
        $this->bestel_aantal = $bestel_aantal;
        $this->afhaaldatum = $afhaaldatum;
        $this->status = $status;
    }
    public static function create($bestelnr, $klantnr, $besteldatum, $bestel_aantal, $afhaaldatum, $status)
    {
        if (!isset(self::$idMap[$bestelnr])){
            self::$idMap[$bestelnr]=new Bestelling($bestelnr, $klantnr, $besteldatum, $bestel_aantal, $afhaaldatum, $status);
        }
        return self::$idMap[$bestelnr];
    }

    //GETTERS
    public function getBestelnr(){return $this->bestelnr;}
    public function getKlantnr(){return $this->klantnr;}
    public function getBesteldatum(){return $this->besteldatum;}
    public function getBestelAantal(){return $this->bestel_aantal;}
    public function getAfhaaldatum(){return $this->afhaaldatum;}
    public function getStatus(){return $this->status;}

    //SETTERS
    public function setKlantnr($klantnr){$this->klantnr= $klantnr;}
//    public function setBesteldatum($besteldatum){$this->besteldatum = $besteldatum;}
    public function setBestelAantal($bestel_aantal){$this->bestel_aantal= $bestel_aantal;}
    public function setAfhaaldatum($afhaaldatum){$this->afhaaldatum = $afhaaldatum;}
    public function setStatus($status){$this->status= $status;}





}