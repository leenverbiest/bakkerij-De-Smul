<?php
/**
 * Created by PhpStorm.
 * User: Leen
 * Date: 12/02/2017
 * Time: 20:11
 */
require_once (ROOT.DS.'entities'.DS.'Product.php');
require_once (ROOT.DS.'models'.DS.'Categorie.model.php');
require_once (ROOT.DS.'entities'.DS.'Validator.php');
require_once (ROOT.DS.'entities'.DS.'ErrorHandler.php');

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
        $this->data['site_titel']=Config::get('site_name');
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
        $this->data['categorielijst']=$catmodel->getAll(); //array van CATEGORIE/objecten
        $this->data['site_titel']=Config::get('site_name');
        $params=App::getRouter()->getParams();
        if (isset($params[0])){
            $categorie=$params[0];
            $this->data['producten']=$this->model->getProductByCategorie($categorie);
        }

//        $this->data['producten']=$this->model->getAll();
    }
    public function admin_categorie(){
        $catmodel=new CategorieModel();
        $this->data['categorielijst']=$catmodel->getAll(); //array van CATEGORIE/objecten
        $this->data['site_titel']=Config::get('site_name');
    }
    public function admin_edit()
    {
        $this->data['site_titel']=Config::get('site_name');
        $params = App::getRouter()->getParams();
        if (isset($params[0])) {
            $id = $params[0];
            $product = $this->model->getById($id);
            $catnr=$product->getCatnr();
            $this->data['productgegevens']=$product;
            $catmodel=new CategorieModel();
            $categorie=$catmodel->getById($catnr);
            $catnaam=$categorie->getCategorie();
            $this->data['categorie']=$catnaam;
            $this->data['categorielijst']=$catmodel->getAll();
            if (isset($_POST)&&!empty($_POST)){
                $catnr = $_POST["categorie"];
                $naam = $_POST["naam"];
                $prijs = $_POST["prijs"];

                $this->model->update($id,$catnr,$naam,$prijs);
                Router::redirect('/product/admin_producten/');
            }

        }

    }
    public function admin_delete()
    {
        $params=App::getRouter()->getParams();
        if (isset($params[0])) {
            $id=$params[0];
            $this->model->delete($id);
            Router::redirect('/product/admin_producten/');
        }
    }
    public function admin_add()
    {
        $this->data['site_titel']=Config::get('site_name');
        $catmodel=new CategorieModel();
        $this->data['categorielijst']=$catmodel->getAll(); //array van CATEGORIE/objecten

        if (isset($_POST)&&!empty($_POST)){
            $categorie = $_POST["categorie"];
            print_r($categorie);
            $naam = $_POST["naam"];
            $prijs = $_POST["prijs"];

            $errorHandler=new Errorhandler();
            $validator=new Validator($errorHandler);
            $validation=$validator->check($_POST,[
                'categorie' => [
                    'verplicht' => true
                ],
                'naam' => [
                    'verplicht' => true
                ],
                'prijs' => [
                    'verplicht' => true
                ]
                ]);
            if($validation->fails()) {
                $params=App::getRouter()->getParams();
                $this->data['foutCategorie']=$validation->errors()->first('categorie');
                $this->data['foutNaam']=$validation->errors()->first('naam');
                $this->data['foutPrijs']=$validation->errors()->first('prijs');

            }
                $product=$this->model->create($categorie,$naam,$prijs);
                $productnr=$product->getProductnr();
                $productgegevens=$this->model->getById($productnr);
                $this->data['product']=$productgegevens;
                Router::redirect('/product/admin_producten/');
        }
    }
    public function catnr()
    {
        $params = App::getRouter()->getParams();
        if (isset($params[0])&& isset($params[1])){

        }
    }

}