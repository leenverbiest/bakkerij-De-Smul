<?php
/**
 * Created by PhpStorm.
 * User: Leen
 * Date: 12/02/2017
 * Time: 20:11
 */
require_once (ROOT.DS.'entities'.DS.'Product.php');
require_once (ROOT.DS.'models'.DS.'Categorie.model.php');

class ProductController extends Controller{


    public function __construct($data=array())
    {
        parent::__construct($data);
        $this->model=new ProductModel();
    }
    public function lijst()
    {
    $catmodel=new CategorieModel();
    $this->data['categorielijst']=$catmodel->getAll(); //array van objecten
    $this->data['producten'] =$this->model->getAll();
    }

    //ADMINISTRATOR
    public function admin_lijst()
    {
        $this->data['producten']=$this->model->getAll();
    }

    public function catnr()
    {
        $params = App::getRouter()->getParams();
        if (isset($params[0])&& isset($params[1])){

        }
    }

}