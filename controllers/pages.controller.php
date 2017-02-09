<?php
/**
 * Created by PhpStorm.
 * User: cyber10
 * Date: 6/02/2017
 * Time: 15:27
 */
class PagesController extends Controller
{
    public function index(){
        $this->data['test_content']= 'Testpagina';
    }
    public function home(){
        $params=App::getRouter()->getParams();

        if (isset($params[0])){
            $alias=strtolower($params[0]);
           $this->data['content']= "Hier komt een pagina met '{$alias}' alias";

        }
    }
}