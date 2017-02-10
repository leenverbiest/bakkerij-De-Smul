<?php
/**
 * Created by PhpStorm.
 * User: Leen
 * Date: 9/02/2017
 * Time: 19:53
 */
class KlantController extends Controller
{
    public function __construct($data=array())
    {
        parent::__construct($data);
        $this->model=new \models\KlantDAO();
    }

    public function index()
    {
        $params = App::getRouter()->getParams();

        if (isset($params[0])) {
            $this->data['bedrijf'] = 'Bakkerij De Smul';
        }
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
        $params=App::getRouter()->getParams();
//        if (isset($params[0])){
//            $this->data['session']
//        }
    }
    public function registreer()
    {
        $params=App::getRouter()->getParams();
    }
    public function klantenlijst()
    {
        $params=App::getRouter()->getParams();
        if (isset($params[0])){
            $this->data['klanten']=$this->model->getAll();
        }
    }

}