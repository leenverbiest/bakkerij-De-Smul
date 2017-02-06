<?php
/**
 * Created by PhpStorm.
 * User: cyber10
 * Date: 6/02/2017
 * Time: 13:06
 */
//https://www.youtube.com/watch?v=lqhX7LU-UrU

define('DS',DIRECTORY_SEPARATOR);
define('ROOT',dirname(__FILE__)); // 1 niveau hoger dan index.php is de root

require_once (ROOT.DS.'lib'.DS.'init.php');

App::run($_SERVER['REQUEST_URI']);