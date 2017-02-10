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

