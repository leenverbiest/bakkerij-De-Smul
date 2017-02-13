<?php
/**
 * Created by PhpStorm.
 * User: cyber10
 * Date: 6/02/2017
 * Time: 13:06
 */


define('DS',DIRECTORY_SEPARATOR);
define('ROOT',dirname(__FILE__)); // 1 niveau hoger dan index.php is de root
define('VIEWS_PATH',ROOT.DS.'views');

require_once (ROOT.DS.'lib'.DS.'init.php');

session_start();
App::run($_SERVER['REQUEST_URI']);

//$router=new Router($_SERVER['REQUEST_URI']);
//
//print_r('Route '.$router->getRoute());
//print_r('Language '.$router->getLanguage());
//print_r('Controller '.$router->getController());
//print_r('Action '.$router->getMethodPrefix().$router->getAction());
//echo 'Params: ';
//print_r($router->getParams());
