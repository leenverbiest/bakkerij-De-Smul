<?php
/**
 * Created by PhpStorm.
 * User: cyber10
 * Date: 2/02/2017
 * Time: 11:44
 */
//presentation/template.php
require_once ('../lib/vendor/Twig/Autoloader.php');

Twig_Autoloader::register();
$loader=new Twig_Loader_Filesystem('views');
$twig=new Twig_Environment($loader);

