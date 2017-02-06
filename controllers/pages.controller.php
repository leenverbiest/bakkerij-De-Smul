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
        echo 'Hier komt de paginalijst';
    }
    public function view(){
        $params=App::getRouter()->getParams();

        if (isset($params[0])){
            $alias=strtolower($params[0]);
            echo "Hier komt een pagina met '{$alias}' alias";
        }
    }
}