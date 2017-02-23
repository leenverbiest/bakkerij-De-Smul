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

    public function winkelmandje(){
            $winkelmandje=Session::get('winkelmandje');
            $this->data['winkelmandje']=$winkelmandje;
            $wmTotaal=0;
            foreach ($winkelmandje as $rij){
                $wmTotaal+=$rij->totaal;
            }
            $this->data['wmTotaal']=$wmTotaal;
        }
    public function wijzig()
    {
        if (Session::get('rechten') == "klant") {

        } else {
            Router::redirect('/klant/login/');
        }
        $params = App::getRouter()->getParams();
        if (isset($params[0])) {
            $productnr = $this->params[0];
            $vorigWinkelmandje = Session::get('winkelmandje');
            $arrWinkelmandje = array_filter(
                $vorigWinkelmandje, function ($e) use (&$productnr) {
                return $e->productnr == $productnr;
            });
//            print_r($arrWinkelmandje);
            $this->data['product'] = $arrWinkelmandje;
            $key=key($arrWinkelmandje);

            if (isset($_POST) && !empty($_POST)) {
                //lees aantal
                $aantal = $_POST['aantal'];
                $prijs=$arrWinkelmandje[$key]->prijs; //haal eenheidsprijs op
                $arrWinkelmandje[$key]->aantal=$aantal;
             $arrWinkelmandje[$key]->totaal=$aantal*$prijs;
            }

        }

    }
//
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