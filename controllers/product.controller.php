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
        $this->data['categorielijst']=$catmodel->getAll(); //array van CATEGORIE/objecten
//        $this->data['producten']=$this->model->getAll(); //array van PRODUCT-objecten
        $params=App::getRouter()->getParams();
        if (isset($params[0])){
            $categorie=$params[0];
        $this->data['producten']=$this->model->getProductByCategorie($categorie);
        }

    }

    //ADMINISTRATOR
    public function admin_index(){
        $this->data['site_titel']=Config::get('site_name');
    }
    public function admin_producten()
    {
        $catmodel=new CategorieModel();
        $this->data['categorielijst']=$catmodel->getAll(); //array van objecten
        $this->data['site_titel']=Config::get('site_name');
        $this->data['producten']=$this->model->getAll();
    }
    public function admin_edit()
    {
        $params=App::getRouter()->getParams();
        if (isset($params[0])) {
        $id=$params[0];
        $this->model->update($id);
        }
    }
    public function admin_delete()
    {
        $params=App::getRouter()->getParams();
        if (isset($params[0])) {
            $id=$params[0];
            $this->model->delete($id);
        }
    }
    public function catnr()
    {
        $params = App::getRouter()->getParams();
        if (isset($params[0])&& isset($params[1])){

        }
    }

}