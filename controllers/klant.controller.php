<?php
/**
 * Created by PhpStorm.
 * User: Leen
 * Date: 9/02/2017
 * Time: 19:53
 */
require_once (ROOT.DS.'lib'.DS.'session.class.php');
require_once (ROOT.DS.'entities'.DS.'Klant.php');
require_once (ROOT.DS.'models'.DS.'Product.model.php');
require_once (ROOT.DS.'models'.DS.'Categorie.model.php');
require_once (ROOT.DS.'models'.DS.'Bestelling.model.php');
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
//    public function productenklant(){
//        if (Session::get('rechten') == "klant" && Session::get('status')==1) {
//            $this->data['site_titel']=Config::get('site_name');
//            $this->data['voornaam']=Session::get('voornaam');
//            $this->data['naam']=Session::get('naam');
//        }else {
//            Router::redirect('/klant/login/');
//        }
//        $catmodel=new CategorieModel();
//        $productmodel=new ProductModel();
//        $this->data['categorielijst']=$catmodel->getAll(); //array van CATEGORIE/objecten
//        $params=App::getRouter()->getParams();
//        if (isset($params[0])){
//            $categorie=$params[0];
//            $this->data['producten']=$productmodel->getProductByCategorie($categorie);
//        }
//    }
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
                Session::set('status',$status);
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
                } elseif($klant && $status==2 && $juistewachtwoord && $rechten) {
                    $this->data['fout'] = 'De toegang werd u geweigerd. Indien u terug toegang wenst, gelieve
                                            ons te contacteren';
                }else{
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
               Session::set('status',$status);

            }
        }
    }
    public function klantpagina(){

        if (Session::get('rechten') == "klant" && Session::get('status')==1) {
            $this->data['site_titel']=Config::get('site_name');
            $this->data['voornaam']=Session::get('voornaam');
            $this->data['naam']=Session::get('naam');
        }else {
            Router::redirect('/klant/login/');
        }
        $catmodel=new CategorieModel();
        $productmodel=new ProductModel();
        $params=App::getRouter()->getParams();
        if (isset($params[0])) {
            $categorie = $params[0];
            $this->data['producten'] = $productmodel->getProductByCategorie($categorie);
            $this->data['categorie'] = $categorie;
            $this->data['categorielijst'] = $catmodel->getAll(); //array van CATEGORIE/objecten

        }if (!isset($params[0])){
            $categorie='brood';
            $this->data['producten'] = $productmodel->getProductByCategorie($categorie);
            $this->data['categorie'] = $categorie;
            $this->data['categorielijst'] = $catmodel->getAll(); //array van CATEGORIE/objecten
        }
        if (Session::get('winkelmandje')&& !empty('winkelmandje')){
            $this->data['teller']=Session::get('teller');
        }
        $teller=count(Session::get('winkelmandje'));  //toont het altijd artikelen in het winkelmandje
        $this->data['teller']=$teller;

        if (isset($_POST) && !empty($_POST)) {
            //lees aantal en productnr
            $aantal = $_POST['aantal'];
            $productnr = $_POST['productnr'];
            //haal het betreffende product op aan de hand van het productnr
            $product=$productmodel->getById($productnr); // OBJECT
            //haal de eenheidsprijs op
            $prijs=$product->getEenheidsprijs();
            //haal de productnaam op
            $naam=$product->getProductnaam();
            //haal het klantnr op
            $klantnr=$this->model->getIdByEmail(Session::get('email'));
            //bepaal de prijs voor de desbetreffende bestellijn
            $prijslijn=$aantal*$prijs;
            //winkelmandje product
            $wmProduct=new stdClass();
            $wmProduct->productnr=$productnr;
            $wmProduct->naam=$naam;
            $wmProduct->aantal=$aantal;
            $wmProduct->prijs=$prijs;
            $wmProduct->totaal=$prijslijn;
//            print $productnr;
            if (Session::get('winkelmandje')){
                $winkelmandje=Session::get('winkelmandje');
            }else{
                $winkelmandje=array();
            }
            //we overlopen of het product reeds opgenomen is in het winkelmandje
            $found=false;
            foreach ($winkelmandje as $rij){
                //indien JA , wijzigen we het aantal
                if ($rij->productnr==$productnr){
                    $rij->aantal=$rij->aantal+$aantal;
                    $found=true;
                    Session::set('winkelmandje',$winkelmandje);
                    $teller=count(Session::get('winkelmandje'));
                    $this->data['teller']=$teller;
                    break;
                }
            }

            if($found===false){

                array_push($winkelmandje,$wmProduct);
                Session::set('winkelmandje',$winkelmandje);
                $teller=count(Session::get('winkelmandje'));
                $this->data['teller']=$teller;
            }

        }
    }
    public function bestellingen()
    {
        if (Session::get('rechten') == "klant" && Session::get('status')==1) {
            $this->data['site_titel']=Config::get('site_name');
            $this->data['voornaam']=Session::get('voornaam');
            $this->data['naam']=Session::get('naam');
        }else {
            Router::redirect('/klant/login/');
        }
        $bestelmodel=new BestellingModel();
        $klantnr=$this->model->getIdByEmail(Session::get('email'));
        $bestellingen=$bestelmodel->getByKlantnr($klantnr); //object
        $this->data['bestellingen']=$bestellingen;

    }
    public function account()
    {
        if (Session::get('rechten') == "klant" && Session::get('status')==1) {
            $this->data['site_titel']=Config::get('site_name');
            $this->data['voornaam']=Session::get('voornaam');
            $this->data['naam']=Session::get('naam');
        }else {
            Router::redirect('/klant/login/');
        }
        $klantgegevens=$this->model->getByEmail(Session::get('email'));
        $this->data['klant']=$klantgegevens;
    }




    //ADMINISTRATOR
    public function klantenlijst()
    {
        if (Session::get('rechten')=="admin"){
            $this->data['site_titel']=Config::get('site_name');
        }else{
            Router::redirect('/klant/login/');
        }
        $this->data['klanten']=$this->model->getAll();
    }
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
    public function admin_edit()
    {
        if (Session::get('rechten') == "admin") {
            $this->data['site_titel'] = Config::get('site_name');
        } else {
            Router::redirect('/klant/login/');
        }
        $params = App::getRouter()->getParams();
        if (isset($params[0])) {
            $id = $params[0];
            $klant = $this->model->getById($id);
            $this->data['klantgegevens']=$klant;

            if (isset($_POST) && !empty($_POST)) {
                Session::set('voornaam',$_POST["txtVoornaam"]);
                Session::set('naam',$_POST ["txtNaam"]);
                Session::set('straat', $_POST["txtStraat"]);
                Session::set('postcode',$_POST['txtPostcode']);
                Session::set('gemeente',$_POST['txtGemeente']);
                Session::set('email',$_POST['txtEmail']);
                Session::set('status',$_POST['txtStatus']);

                //valideer input en pass it to de ValidatorController
//                $errorHandler=new Errorhandler();
//                $validator=new Validator($errorHandler);
//                $validation=$validator->check($_POST,[
//                    'voornaam' => [
//                        'verplicht' => true,
//                        'tekst' => true
//                    ],
//                    'naam' => [
//                        'verplicht' => true,
//                        'tekst' => true
//                    ],
//                    'straat' => [
//                        'verplicht' => true
//                    ],
//                    'postcode'=>[
//                        'verplicht'=>true,
//                        'lengte'=>4
//                    ],
//                    'gemeente' => [
//                        'verplicht' => true,
//                        'gemeente'=>true
//                    ],
//                    'email' => [
//                        'verplicht' => true,
//                        'email' => true
//                    ]
//                ]);
//                if($validation->fails()) {
//                    $params = App::getRouter()->getParams();
//                    $this->data['foutVoornaam'] = $validation->errors()->first('voornaam');
//                    $this->data['foutNaam'] = $validation->errors()->first('naam');
//                    $this->data['foutStraat'] = $validation->errors()->first('straat');
//                    $this->data['foutPostcode'] = $validation->errors()->first('postcode');
//                    $this->data['foutGemeente'] = $validation->errors()->first('gemeente');
//                    $this->data['foutEmail'] = $validation->errors()->first('email');
//                }
                if(Session::get('voornaam')==true ?$bvoornaam=Session::get('voornaam'):$bvoornaam=$klant->getVoornaam());
                $bnaam=Session::get('naam')?Session::get('naam'):$klant->getNaam();
                $bstraat=Session::get('straat')?Session::get('straat'):$klant->getStraat();
                $bpostcode=Session::get('postcode')?Session::get('postcode'):$klant->getPostcode();
                $bgemeente=Session::get('gemeente')?Session::get('gemeente'):$klant->getGemeente();
                $bemail=Session::get('email')?Session::get('email'):$klant->getEmail();
                $bstatus=Session::get('status')?Session::get('status'):$klant->getStatus();


//                print $id;
//                print $bvoornaam;
//                print $bnaam;
//                print $bstraat;
//                print $bpostcode;
//                print $bgemeente;
//                print $bemail;
//
//                print $bstatus;
//                print $rechten;
                $this->model->update($id,$bvoornaam,$bnaam,$bstraat,$bpostcode,$bgemeente,$bemail,
                                     $bstatus);
                Router::redirect('/klant/klantenlijst/');

            }
        }
    }
    public function admin_add(){
        if (Session::get('rechten')=="admin"){
            $this->data['site_titel']=Config::get('site_name');
        }else{
            Router::redirect('/klant/login/');
        }
    }


}