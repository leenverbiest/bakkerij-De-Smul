<?php
/**
 * Created by PhpStorm.
 * User: Leen
 * Date: 14/02/2017
 * Time: 17:12
 */
require_once (ROOT.DS.'entities'.DS.'Categorie.php');
require_once (ROOT.DS.'entities'.DS.'Validator.php');
require_once (ROOT.DS.'entities'.DS.'ErrorHandler.php');

class CategorieController extends Controller{

    public function __construct($data=array())
    {
        parent::__construct($data);
        $this->model=new CategorieModel();
    }
    public function admin_categorie(){
        if (Session::get('rechten')=="admin"){
            $this->data['site_titel']=Config::get('site_name');
        }else{
            Router::redirect('/klant/login/');
        }
        $this->data['categorielijst']=$this->model->getAll(); //array van CATEGORIE/objecten

    }
}