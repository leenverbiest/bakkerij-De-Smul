<?php
/**
 * Created by PhpStorm.
 * User: cyber10
 * Date: 13/02/2017
 * Time: 9:35
 */
//Deze controller bevat enkel de indexpagina van de administrator

class AdminController extends Controller{

    public function admin_index(){
        $this->data['site_titel']=Config::get('site_name');
        }

}