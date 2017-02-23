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
require_once ( ROOT.DS.'models'.DS.'Klant.model.php');
require_once (ROOT.DS.'models'.DS.'Bestellijn.model.php');
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
        $klantmodel=new KlantModel();
        $klantnr=$klantmodel->getIdByEmail(Session::get('email'));
        $openstaandeBestelling=$this->model->getByKlantnr($klantnr);
        $key=key($openstaandeBestelling);
        $afdatum=$openstaandeBestelling[$key]->getAfhaaldatum();


        $winkelmandje=Session::get('winkelmandje');
        $this->data['winkelmandje']=$winkelmandje;
        $wmTotaal=0;
        foreach ($winkelmandje as $rij){
            $wmTotaal+=$rij->totaal;
        }
        $this->data['wmTotaal']=$wmTotaal;
        if (isset($_POST)&& !empty($_POST)){
            $afhaaldatum=$_POST['afhaaldatum'];
            Session::set('afhaaldatum',$afhaaldatum);
            Session::set('besteltotaal',$wmTotaal);
            Router::redirect('/bestelling/bevestiging/');
        }else{
            echo 'Gelieve een afhaaldatum te selecteren';
        }

    }
    public function bevestiging(){
        if (Session::get('rechten') == "klant" && Session::get('status')==1) {
            $this->data['site_titel']=Config::get('site_name');
            $this->data['voornaam']=Session::get('voornaam');
            $this->data['naam']=Session::get('naam');
        }else {
            Router::redirect('/klant/login/');
        }
        $afhaaldatum=Session::get('afhaaldatum');
        $arrbestelling=Session::get('winkelmandje');
        $besteltotaal=Session::get('besteltotaal');
        $this->data['afhaaldatum']=$afhaaldatum;
        $this->data['bestelling']=$arrbestelling;
        $this->data['totaal']=$besteltotaal;
        $bestelaantal=0;
        foreach ($arrbestelling as $rij){
            $bestelaantal+=$rij->aantal;
        }
        $email=Session::get('email');
        $klantmodel=new KlantModel();
        $blijnmodel=new BestellijnModel();
        $klantnr=$klantmodel->getIdByEmail($email);
        $besteldatum=date('Y-m-d H:i:s');
        $status='af te halen';
        $bestelling=$this->model->create($klantnr,$besteldatum,$bestelaantal,$afhaaldatum,$status);
        $bestelnr=$bestelling->getBestelnr();
        foreach ($arrbestelling as $rij){
            $bestellijn=$blijnmodel->create($bestelnr,$rij->productnr,$rij->aantal);

        }
        Session::delete('winkelmandje');

        }
        public function annuleer()
        {
            if (Session::get('rechten') == "klant") {

            } else {
                Router::redirect('/klant/login/');
            }
            $params = App::getRouter()->getParams();
            if (isset($params[0])) {
                $bestelnr = $params[0];
                $this->model->delete($bestelnr);

                Router::redirect('/klant/bestellingen/');

            }


        }

}