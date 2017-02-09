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
            $this->data['klantnr'] = '34';
        }
    }
    public function home(){
        $params=App::getRouter()->getParams();

        if (isset($params[0])){
//            $alias=strtolower($params[0]);
           $this->data['klant']= "Leen Verbiest";

        }
    }
}