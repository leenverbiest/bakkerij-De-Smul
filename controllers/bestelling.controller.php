<?php
/**
 * Created by PhpStorm.
 * User: cyber10
 * Date: 15/02/2017
 * Time: 10:53
 */
require_once (ROOT.DS.'lib'.DS.'session.class.php');
require_once (ROOT.DS.'entities'.DS.'Bestelling.php');
require_once (ROOT.DS.'models'.DS.'Product.model.php');
require_once (ROOT.DS.'entities'.DS.'Validator.php');
require_once (ROOT.DS.'entities'.DS.'ErrorHandler.php');

class BestellingController extends Controller{


    /**
     * BestellingController constructor.
     */
    public function __construct($data=array())
    {
        parent::__construct($data);
        $this->model=new BestellingModel();
    }

    public function bestelling(){

    }
    public function winkelmandje(){
      $this->data['winkelmandje']=Session::get('winkelmandje');



        }





}