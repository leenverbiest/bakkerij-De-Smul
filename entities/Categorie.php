<?php

/**
 * Created by PhpStorm.
 * User: Leen
 * Date: 12/02/2017
 * Time: 20:11
 */
class Categorie
{
    private static $idMap=array();
    private $catnr;
    private $categorie;

    /*de constructor function is private zodat er van buiten de klasse Categorie
     *geen nieuw Categorie-object meer aangemaakt kan worden
     */
    private function __construct($catnr,$categorie)
    {
        $this->catnr=$catnr;
        $this->categorie=$categorie;
    }
    public function create($catnr,$categorie){
        if(!isset(self::$idMap[$catnr])){
            self::$idMap[$catnr]=new Categorie($catnr,$categorie);
        }
        return self::$idMap[$catnr];
    }

    //GETTERS
    public function getCatnr(){return $this->catnr;}
    public function getCategorie(){return $this->categorie;}

    //SETTERS
    public function setCatnr($catnr){$this->catnr=$catnr;}
    public function setCategorie($categorie){$this->categorie=$categorie;}
}