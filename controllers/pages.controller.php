<?php
/**
 * Created by PhpStorm.
 * User: cyber10
 * Date: 6/02/2017
 * Time: 15:27
 */
class PagesController extends Controller
{
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


}