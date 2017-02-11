<?php
/**
 * Created by PhpStorm.
 * User: Leen
 * Date: 10/02/2017
 * Time: 18:18
 */
require_once (ROOT.DS.'entities'.DS.'Validator.php');
require_once (ROOT.DS.'entities'.DS.'ErrorHandler.php');

class ValidatorController extends Controller{

    public function __construct($data=array())
    {
        parent::__construct($data);

        $this->entity=new Validator($this->entity=new Errorhandler());
    }
    public function validate(){
        $this->entity->check(Session::get('gegevens'),$this->entity->getRules());
        if($this->entity->fails()){
           return $this->entity->errors();




        }else{
            Router::redirect('/klant/registreer/');
        }
    }



}
