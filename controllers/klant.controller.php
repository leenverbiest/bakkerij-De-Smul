<?php
/**
 * Created by PhpStorm.
 * User: Leen
 * Date: 9/02/2017
 * Time: 19:53
 */
require_once (ROOT.DS.'lib'.DS.'session.class.php');
require_once (ROOT.DS.'entities'.DS.'Klant.php');
class KlantController extends Controller
{
    public function __construct($data=array())
    {
        parent::__construct($data);
        $this->model=new KlantModel();
    }

    public function index()
    {

        if (Session::hasFlash()){
            $this->data["bericht"]=Session::flash();
        }
        $this->data['bedrijf'] = 'Bakkerij De Smul';


    }
    public function home()
    {
        $params = App::getRouter()->getParams();

        if (isset($params[0])) {
            $this->data['klant'] = "Leen Verbiest";

        }
    }
    public function login()
    {
        if ($_POST && isset($_POST['email']) && isset($_POST['wachtwoord'])) {
            $klant = $this->model->getByEmail($_POST['email']);
            $dbwachtwoord =$klant->getWachtwoord();
            $wachtwoord=$_POST['wachtwoord'];
            print $dbwachtwoord;
            print($_POST['wachtwoord']);
            $status=$klant->getStatus();
            $juistewachtwoord=password_verify($_POST['wachtwoord'],$dbwachtwoord);
            print $juistewachtwoord;
            if (password_verify($wachtwoord,$dbwachtwoord)){
                Session::setFlash('Geldig wachtwoord');
            }else{
                Session::setFlash('Ongeldig wachtwoord');
            }
            if (Session::hasFlash()){
                $this->data['geldig']=Session::flash();
            }


//            if ($klant && $status && $juistewachtwoord) {
//                Session::set('email',$klant->getEmail());
//                Session::set('voornaam',$klant->getVoornaam());
//                Session::set('naam',$klant->getNaam());
//             Router::redirect('/klant/klantpagina');
//            }else{
//                echo 'fout wachtwoord';
//            }
//            Router::redirect('/klant/');
        }
    }
    public function afmelden(){
        Session::destroy();
        Router::redirect('/klant/');
    }
    public function registreer()
    {
        if (isset($_POST)&&!empty($_POST)){
            $voornaam = $_POST["voornaam"];
            $naam = $_POST["naam"];
            $straat = $_POST["straat"];
            $postcode=$_POST["postcode"];
            $gemeente = $_POST['gemeente'];
            $email = $_POST['email'];
            $status='1';
            $tekens=array_merge(range('A','Z'),range(0,9));
            //wachtwoord genereren
            $wachtwoord='';
            for($i=0;$i<6;$i++){
                $wachtwoord .=$tekens[rand(0,count($tekens)-1)];
            }
            $klant=$this->model->create($voornaam,$naam,$straat,$postcode,$gemeente,$email,$status,$wachtwoord);
            $klantnr=$klant->getKlantnr();
            $klantgegevens=$this->model->getById($klantnr);
            $this->data['naam']=$klantgegevens->getNaam();
            Session::set('naam',$klantgegevens->getNaam());

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

}