<?php
/**
 * Created by PhpStorm.
 * User: cyber10
 * Date: 15/02/2017
 * Time: 10:53
 */
require_once (ROOT.DS.'lib'.DS.'session.class.php');
require_once (ROOT.DS.'entities'.DS.'Bestellijn.php');
require_once (ROOT.DS.'models'.DS.'Product.model.php');
require_once (ROOT.DS.'entities'.DS.'Validator.php');
require_once (ROOT.DS.'entities'.DS.'ErrorHandler.php');

class BestellijnController extends Controller{


    /**
     * BestellingController constructor.
     */
    public function __construct($data=array())
    {
        parent::__construct($data);
        $this->model=new BestellijnModel();
    }

    public function bestellijn(){

    }

        public function winkelmandje(){
            $this->data['winkelmandje']=Session::get('winkelmandje');


        }
    public function delete()
    {
        if (Session::get('rechten')=="klant"){

        }else{
            Router::redirect('/klant/login/');
        }
        $params=App::getRouter()->getParams();
        if (isset($params[0])) {
            $arrWinkelmandje=Session::get('winkelmandje');
            $arrWinkelmandje=array_filter(
                $arrWinkelmandje,function($e){
                    return $e->productnr !=$this->params[0];
            });
            Session::delete('winkelmandje');
            Session::set('winkelmandje',$arrWinkelmandje);

            Router::redirect('/bestellijn/winkelmandje/');
        }
    }







}