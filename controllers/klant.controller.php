<?php
/**
 * Created by PhpStorm.
 * User: Leen
 * Date: 9/02/2017
 * Time: 19:53
 */
require_once (ROOT.DS.'lib'.DS.'session.class.php');
require_once (ROOT.DS.'entities'.DS.'Klant.php');
require_once (ROOT.DS.'entities'.DS.'Validator.php');
require_once (ROOT.DS.'entities'.DS.'ErrorHandler.php');



class KlantController extends Controller
{
    public function __construct($data=array())
    {
        parent::__construct($data);
        $this->model=new KlantModel();
//        $this->entity=new Validator($this->entity=new Errorhandler());

    }

    public function index()
    {
        if (Session::get('email') && !empty(Session::get('email')&& Session::get('rechten'))) {
            switch (Session::get('rechten')){
                case 'klant':
                    Router::redirect('/klant/klantpagina/');
                    break;
                case 'admin':
                    Router::redirect('/klant/admin_index/');
                    break;
            }
        }
        if (Session::hasFlash()){
            $this->data["bericht"]=Session::flash();
        }
        $this->data['bedrijf'] = 'Bakkerij De Smul';
    }
    public function home()
    {
        if (Session::get('email') && !empty(Session::get('email'))) {
            Router::redirect('/klant/klantpagina/');
        }

    }
    public function login()
    {
        if (Session::get('email') && !empty(Session::get('email')&& Session::get('rechten')&& !empty(Session::get('rechten')))) {

            switch (Session::get('rechten')){
                case 'klant':
                    Router::redirect('/klant/klantpagina/');
                    break;
                case 'admin':
                    Router::redirect('/klant/admin_index/');
                    break;
            }
        }
        else {

            if ($_POST && isset($_POST['email']) && isset($_POST['wachtwoord'])) {
                $klant = $this->model->getByEmail($_POST['email']);
                $dbwachtwoord = $klant->getWachtwoord();
                $wachtwoord = $_POST['wachtwoord'];
                $email = $klant->getEmail();
                $status = $klant->getStatus();
                $rechten=$klant->getRechten();
                $juistewachtwoord = password_verify($wachtwoord, $dbwachtwoord);

                if ($klant && $status == 1 && $juistewachtwoord && $rechten) {
                    Session::set('email', $klant->getEmail());
                    Session::set('voornaam', $klant->getVoornaam());
                    Session::set('naam', $klant->getNaam());
                    Session::set('rechten',$klant->getRechten());
                    switch ($rechten){
                        case 'klant':
                            Router::redirect('/klant/klantpagina');
                            break;
                        case 'admin':
                            Router::redirect('/klant/admin_index/');
                            break;
                    }
                } else {
                    $this->data['fout'] = 'foutief wachtwoord';
                }
            }
        }
    }
    public function afmelden(){
        Session::destroy();
        Router::redirect('/klant/login/');
    }
    public function registreer()
    {
        if (Session::get('email') && !empty(Session::get('email'))) {
            Router::redirect('/klant/klantpagina/');
        }
        if (isset($_POST)&&!empty($_POST)){
            $voornaam = $_POST["voornaam"];
            $naam = $_POST["naam"];
            $straat = $_POST["straat"];
            $postcode=$_POST["postcode"];
            $gemeente = $_POST['gemeente'];
            $email = $_POST['email'];
            $this->data['voornaam']=$voornaam;
            $this->data['naam']=$naam;
            $this->data['straat']=$straat;
            $this->data['postcode']=$postcode;
            $this->data['gemeente']=$gemeente;
            $this->data['email']=$email;
            $status='1';
            $rechten='klant';

//            $this->data['wachtwoord']=$wachtwoord;
            //valideer input en pass it to de ValidatorController
            $errorHandler=new Errorhandler();
            $validator=new Validator($errorHandler);
            $validation=$validator->check($_POST,[
                'voornaam' => [
                    'verplicht' => true,
                    'tekst' => true
                ],
                'naam' => [
                    'verplicht' => true,
                    'tekst' => true
                ],
                'straat' => [
                    'verplicht' => true
                ],
                'postcode'=>[
                    'verplicht'=>true,
                    'lengte'=>4
                ],
                'gemeente' => [
                    'verplicht' => true,
                    'gemeente'=>true
                ],
                'email' => [
                    'verplicht' => true,
                    'email' => true
                ]
            ]);
            if($validation->fails()) {
                $params=App::getRouter()->getParams();
                $this->data['foutVoornaam']=$validation->errors()->first('voornaam');
                $this->data['foutNaam']=$validation->errors()->first('naam');
                $this->data['foutStraat']=$validation->errors()->first('straat');
                $this->data['foutPostcode']=$validation->errors()->first('postcode');
                $this->data['foutGemeente']=$validation->errors()->first('gemeente');
                $this->data['foutEmail']=$validation->errors()->first('email');

            }else{
                $tekens=array_merge(range('A','Z'),range(0,9));
                //wachtwoord genereren
                $wachtwoord='';
                for($i=0;$i<6;$i++){
                    $wachtwoord .=$tekens[rand(0,count($tekens)-1)];
                }
               $klant=$this->model->create($voornaam,$naam,$straat,$postcode,$gemeente,$email,$wachtwoord,$status,$rechten);
               $klantnr=$klant->getKlantnr();
               $klantgegevens=$this->model->getById($klantnr);
               $this->data['klant']=$klantgegevens;
               $this->data['wachtwoord']=$wachtwoord; //het ungehashte wachtwoord
                $email=$klantgegevens->getEmail();
               Session::set('klantnr',$klantnr);
               Session::set('naam',$naam);
               Session::set('voornaam',$voornaam);
               Session::set('rechten',$rechten);

            }
        }
    }
    public function klantpagina(){
        $params=App::getRouter()->getParams();
        $this->data['voornaam']=Session::get('voornaam');
        $this->data['naam']=Session::get('naam');
    }
    public function klantenlijst()
    {
        $params=App::getRouter()->getParams();
        if (isset($params[0])){
            $this->data['klanten']=$this->model->getAll();

        }
    }
    //ADMINISTRATOR
    public function admin_index(){
        if (Session::get('rechten')=="admin"){
            $this->data['site_titel']=Config::get('site_name');
        }else{
            Router::redirect('/klant/login/');
        }
    }
    public function admin_afmelden(){
        Session::destroy();
        Router::redirect('/klant/login/');
    }


}